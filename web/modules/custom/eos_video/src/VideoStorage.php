<?php

namespace Drupal\eos_video;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\eos_video\Entity\VideoInterface;

/**
 * Defines the storage handler class for Video entities.
 *
 * This extends the base storage class, adding required special handling for
 * Video entities.
 *
 * @ingroup eos_video
 */
class VideoStorage extends SqlContentEntityStorage implements VideoStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(VideoInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {video_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {video_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(VideoInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {video_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('video_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
