<?php

namespace Drupal\atlas_products\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Disk entity entities.
 *
 * @ingroup atlas_products
 */
interface DiskEntityInterface extends  ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Disk entity name.
   *
   * @return string
   *   Name of the Disk entity.
   */
  public function getName();

  /**
   * Sets the Disk entity name.
   *
   * @param string $name
   *   The Disk entity name.
   *
   * @return \Drupal\atlas_products\Entity\DiskEntityInterface
   *   The called Disk entity entity.
   */
  public function setName($name);

  /**
   * Gets the Disk entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Disk entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Disk entity creation timestamp.
   *
   * @param int $timestamp
   *   The Disk entity creation timestamp.
   *
   * @return \Drupal\atlas_products\Entity\DiskEntityInterface
   *   The called Disk entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Disk entity published status indicator.
   *
   * Unpublished Disk entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Disk entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Disk entity.
   *
   * @param bool $published
   *   TRUE to set this Disk entity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\atlas_products\Entity\DiskEntityInterface
   *   The called Disk entity entity.
   */
  public function setPublished($published);

}
