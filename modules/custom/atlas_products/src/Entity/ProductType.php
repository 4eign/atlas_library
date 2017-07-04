<?php

namespace Drupal\atlas_products\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Defines the Product type entity.
 *
 * @ConfigEntityType(
 *   id = "product_type",
 *   label = @Translation("Product type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\atlas_products\ProductTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\atlas_products\Form\ProductTypeForm",
 *       "edit" = "Drupal\atlas_products\Form\ProductTypeForm",
 *       "delete" = "Drupal\atlas_products\Form\ProductTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\atlas_products\ProductTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "product_type",
 *   admin_permission = "administer site configuration",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/product_type/{product_type}",
 *     "add-form" = "/admin/structure/product_type/add",
 *     "edit-form" = "/admin/structure/product_type/{product_type}/edit",
 *     "delete-form" = "/admin/structure/product_type/{product_type}/delete",
 *     "collection" = "/admin/structure/product_type"
 *   }
 * )
 */
class ProductType extends ConfigEntityBase implements ProductTypeInterface {

  /**
   * The Product type ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Product type label.
   *
   * @var string
   */
  protected $label;

}
