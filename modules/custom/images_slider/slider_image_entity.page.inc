<?php

/**
 * @file
 * Contains slider_image_entity.page.inc.
 *
 * Page callback for Slider image entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Slider image entity templates.
 *
 * Default template: slider_image_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_slider_image_entity(array &$variables) {
  // Fetch SliderImageEntity Entity Object.
  $slider_image_entity = $variables['elements']['#slider_image_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
