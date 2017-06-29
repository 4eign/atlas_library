<?php

namespace Drupal\atlas_products\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Long play entity entities.
 *
 * @ingroup atlas_products
 */
interface LongPlayEntityInterface extends  ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Long play entity name.
   *
   * @return string
   *   Name of the Long play entity.
   */
  public function getName();

  /**
   * Sets the Long play entity name.
   *
   * @param string $name
   *   The Long play entity name.
   *
   * @return \Drupal\atlas_products\Entity\LongPlayEntityInterface
   *   The called Long play entity entity.
   */
  public function setName($name);

  /**
   * Gets the Long play entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Long play entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Long play entity creation timestamp.
   *
   * @param int $timestamp
   *   The Long play entity creation timestamp.
   *
   * @return \Drupal\atlas_products\Entity\LongPlayEntityInterface
   *   The called Long play entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Long play entity published status indicator.
   *
   * Unpublished Long play entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Long play entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Long play entity.
   *
   * @param bool $published
   *   TRUE to set this Long play entity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\atlas_products\Entity\LongPlayEntityInterface
   *   The called Long play entity entity.
   */
  public function setPublished($published);

}
