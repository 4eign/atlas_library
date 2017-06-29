<?php

namespace Drupal\atlas_products;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Long play entity entity.
 *
 * @see \Drupal\atlas_products\Entity\LongPlayEntity.
 */
class LongPlayEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\atlas_products\Entity\LongPlayEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished long play entity entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published long play entity entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit long play entity entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete long play entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add long play entity entities');
  }

}
