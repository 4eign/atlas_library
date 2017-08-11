<?php

namespace Drupal\images_slider\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Slider image entity entities.
 *
 * @ingroup images_slider
 */
interface SliderImageEntityInterface extends  ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Add get/set methods for your configuration properties here.

  /**
   * Gets the Slider image entity name.
   *
   * @return string
   *   Name of the Slider image entity.
   */
  public function getName();

  /**
   * Sets the Slider image entity name.
   *
   * @param string $name
   *   The Slider image entity name.
   *
   * @return \Drupal\images_slider\Entity\SliderImageEntityInterface
   *   The called Slider image entity entity.
   */
  public function setName($name);

  /**
   * Gets the Slider image entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Slider image entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Slider image entity creation timestamp.
   *
   * @param int $timestamp
   *   The Slider image entity creation timestamp.
   *
   * @return \Drupal\images_slider\Entity\SliderImageEntityInterface
   *   The called Slider image entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Slider image entity published status indicator.
   *
   * Unpublished Slider image entity are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Slider image entity is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Slider image entity.
   *
   * @param bool $published
   *   TRUE to set this Slider image entity to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\images_slider\Entity\SliderImageEntityInterface
   *   The called Slider image entity entity.
   */
  public function setPublished($published);

}
