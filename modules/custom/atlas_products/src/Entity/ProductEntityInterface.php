<?php

namespace Drupal\atlas_products\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Product entity entities.
 *
 * @ingroup atlas_products
 */
interface ProductEntityInterface extends  ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Product entity name.
   *
   * @return string
   *   Name of the Product entity.
   */
  public function getName();

  /**
   * Sets the Product entity name.
   *
   * @param string $name
   *   The Product entity name.
   *
   * @return \Drupal\atlas_products\Entity\ProductEntityInterface
   *   The called Product entity entity.
   */
  public function setName($name);

  /**
   * Gets the Product entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Product entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Product entity creation timestamp.
   *
   * @param int $timestamp
   *   The Product entity creation timestamp.
   *
   * @return \Drupal\atlas_products\Entity\ProductEntityInterface
   *   The called Product entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Product entity published status indicator.
   *
   * Unpublished Product entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Product entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Product entity.
   *
   * @param bool $published
   *   TRUE to set this Product entity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\atlas_products\Entity\ProductEntityInterface
   *   The called Product entity entity.
   */
  public function setPublished($published);

}
