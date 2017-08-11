<?php

namespace Drupal\images_slider;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Slider image entity entity.
 *
 * @see \Drupal\images_slider\Entity\SliderImageEntity.
 */
class SliderImageEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\images_slider\Entity\SliderImageEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished slider image entity entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published slider image entity entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit slider image entity entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete slider image entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add slider image entity entities');
  }

}
