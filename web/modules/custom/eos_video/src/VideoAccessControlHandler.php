<?php

namespace Drupal\eos_video;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Video entity.
 *
 * @see \Drupal\eos_video\Entity\Video.
 */
class VideoAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\eos_video\Entity\VideoInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished video entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published video entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit video entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete video entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add video entities');
  }

}
