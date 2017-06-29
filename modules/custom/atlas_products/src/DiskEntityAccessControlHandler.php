<?php

namespace Drupal\atlas_products;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Disk entity entity.
 *
 * @see \Drupal\atlas_products\Entity\DiskEntity.
 */
class DiskEntityAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\atlas_products\Entity\DiskEntityInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished disk entity entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published disk entity entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit disk entity entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete disk entity entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add disk entity entities');
  }

}
