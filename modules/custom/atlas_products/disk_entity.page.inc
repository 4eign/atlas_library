<?php

/**
 * @file
 * Contains disk_entity.page.inc.
 *
 * Page callback for Disk entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Disk entity templates.
 *
 * Default template: disk_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_disk_entity(array &$variables) {
  // Fetch DiskEntity Entity Object.
  $disk_entity = $variables['elements']['#disk_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
