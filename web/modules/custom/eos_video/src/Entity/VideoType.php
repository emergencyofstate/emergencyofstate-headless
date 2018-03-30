<?php

namespace Drupal\eos_video\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Video type entity.
 *
 * @ConfigEntityType(
 *   id = "video_type",
 *   label = @Translation("Video type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\eos_video\VideoTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\eos_video\Form\VideoTypeForm",
 *       "edit" = "Drupal\eos_video\Form\VideoTypeForm",
 *       "delete" = "Drupal\eos_video\Form\VideoTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\eos_video\VideoTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "video_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "video",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/video_type/{video_type}",
 *     "add-form" = "/admin/structure/video_type/add",
 *     "edit-form" = "/admin/structure/video_type/{video_type}/edit",
 *     "delete-form" = "/admin/structure/video_type/{video_type}/delete",
 *     "collection" = "/admin/structure/video_type"
 *   }
 * )
 */
class VideoType extends ConfigEntityBundleBase implements VideoTypeInterface {

  /**
   * The Video type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Video type label.
   *
   * @var string
   */
  protected $label;

}
