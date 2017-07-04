<?php

namespace Drupal\atlas_products\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Product entity entity.
 *
 * @ingroup atlas_products
 *
 * @ContentEntityType(
 *   id = "product_entity",
 *   label = @Translation("Product entity"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\atlas_products\ProductEntityListBuilder",
 *     "views_data" = "Drupal\atlas_products\Entity\ProductEntityViewsData",
 *     "translation" = "Drupal\atlas_products\ProductEntityTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\atlas_products\Form\ProductEntityForm",
 *       "add" = "Drupal\atlas_products\Form\ProductEntityForm",
 *       "edit" = "Drupal\atlas_products\Form\ProductEntityForm",
 *       "delete" = "Drupal\atlas_products\Form\ProductEntityDeleteForm",
 *     },
 *     "access" = "Drupal\atlas_products\ProductEntityAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\atlas_products\ProductEntityHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "product_entity",
 *   data_table = "product_entity_field_data",
 *   translatable = TRUE,
 *   admin_permission = "administer product entity entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/product_entity/{product_entity}",
 *     "add-form" = "/admin/structure/product_entity/add",
 *     "edit-form" = "/admin/structure/product_entity/{product_entity}/edit",
 *     "delete-form" = "/admin/structure/product_entity/{product_entity}/delete",
 *     "collection" = "/admin/structure/product_entity",
 *   },
 *   field_ui_base_route = "product_entity.settings"
 * )
 */
class ProductEntity extends ContentEntityBase implements ProductEntityInterface {

  use EntityChangedTrait;

  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isPublished() {
    return (bool) $this->getEntityKey('status');
  }

  /**
   * {@inheritdoc}
   */
  public function setPublished($published) {
    $this->set('status', $published ? TRUE : FALSE);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the Product entity entity.'))
      ->setRevisionable(TRUE)
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setTranslatable(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the Product entity entity.'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Product entity is published.'))
      ->setDefaultValue(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));
  
    $fields['title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Product'))
      ->setDescription(t('Product title.'))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
  
    $fields['author'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Author'))
      ->setDescription(t("Product's author."))
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
  
    $fields['description'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Product description'))
      ->setDescription(t("Resume of the book."))
      ->setSettings([
        'max_length' => 300,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textarea',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
  
    $fields['type'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Book type'))
      ->setDescription(t('A boolean indicating whether the book is new.'))
      ->setDefaultValue(TRUE);
  
    $fields['price'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Individual book price'))
      ->setDescription(t('The price of one individual book'))
      ->setRequired(TRUE)
      ->setRevisionable(TRUE);
  
    $fields['quantity'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Quantity'))
      ->setDescription(t('Number of the books with the same characteristics'))
      ->setRequired(TRUE)
      ->setRevisionable(TRUE);
  
    $fields['priced_date'] = BaseFieldDefinition::create('changed')   //todo revisar si esto es una fecha cualquiera
    ->setLabel(t('Priced date'))  //todo revisar si esta bien escrito el label
    ->setDescription(t('The date the price was updated.'));
  
    //todo add book category
  
    //todo add image widget

    return $fields;
  }

}
