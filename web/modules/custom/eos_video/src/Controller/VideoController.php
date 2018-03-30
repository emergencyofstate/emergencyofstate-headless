<?php

namespace Drupal\eos_video\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\eos_video\Entity\VideoInterface;

/**
 * Class VideoController.
 *
 *  Returns responses for Video routes.
 */
class VideoController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * Displays a Video  revision.
   *
   * @param int $video_revision
   *   The Video  revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($video_revision) {
    $video = $this->entityManager()->getStorage('video')->loadRevision($video_revision);
    $view_builder = $this->entityManager()->getViewBuilder('video');

    return $view_builder->view($video);
  }

  /**
   * Page title callback for a Video  revision.
   *
   * @param int $video_revision
   *   The Video  revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($video_revision) {
    $video = $this->entityManager()->getStorage('video')->loadRevision($video_revision);
    return $this->t('Revision of %title from %date', ['%title' => $video->label(), '%date' => format_date($video->getRevisionCreationTime())]);
  }

  /**
   * Generates an overview table of older revisions of a Video .
   *
   * @param \Drupal\eos_video\Entity\VideoInterface $video
   *   A Video  object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(VideoInterface $video) {
    $account = $this->currentUser();
    $langcode = $video->language()->getId();
    $langname = $video->language()->getName();
    $languages = $video->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $video_storage = $this->entityManager()->getStorage('video');

    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $video->label()]) : $this->t('Revisions for %title', ['%title' => $video->label()]);
    $header = [$this->t('Revision'), $this->t('Operations')];

    $revert_permission = (($account->hasPermission("revert all video revisions") || $account->hasPermission('administer video entities')));
    $delete_permission = (($account->hasPermission("delete all video revisions") || $account->hasPermission('administer video entities')));

    $rows = [];

    $vids = $video_storage->revisionIds($video);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\eos_video\VideoInterface $revision */
      $revision = $video_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = \Drupal::service('date.formatter')->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $video->getRevisionId()) {
          $link = $this->l($date, new Url('entity.video.revision', ['video' => $video->id(), 'video_revision' => $vid]));
        }
        else {
          $link = $video->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => \Drupal::service('renderer')->renderPlain($username),
              'message' => ['#markup' => $revision->getRevisionLogMessage(), '#allowed_tags' => Xss::getHtmlTagList()],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.video.translation_revert', ['video' => $video->id(), 'video_revision' => $vid, 'langcode' => $langcode]) :
              Url::fromRoute('entity.video.revision_revert', ['video' => $video->id(), 'video_revision' => $vid]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.video.revision_delete', ['video' => $video->id(), 'video_revision' => $vid]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['video_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
