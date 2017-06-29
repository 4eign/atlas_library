<?php

/**
 * @file
 * Contains long_play_entity.page.inc.
 *
 * Page callback for Long play entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Long play entity templates.
 *
 * Default template: long_play_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_long_play_entity(array &$variables) {
  // Fetch LongPlayEntity Entity Object.
  $long_play_entity = $variables['elements']['#long_play_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
