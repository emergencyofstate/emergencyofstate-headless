<?php

namespace Drupal\eos_video\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class VideoTypeForm.
 */
class VideoTypeForm extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $video_type = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $video_type->label(),
      '#description' => $this->t("Label for the Video type."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $video_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\eos_video\Entity\VideoType::load',
      ],
      '#disabled' => !$video_type->isNew(),
    ];

    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $video_type = $this->entity;
    $status = $video_type->save();

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Video type.', [
          '%label' => $video_type->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Video type.', [
          '%label' => $video_type->label(),
        ]));
    }
    $form_state->setRedirectUrl($video_type->toUrl('collection'));
  }

}
