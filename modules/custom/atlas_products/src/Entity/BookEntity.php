<?php

namespace Drupal\atlas_products\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Book entity entity.
 *
 * @ingroup atlas_products
 *
 * @ContentEntityType(
 *   id = "book_entity",
 *   label = @Translation("Book entity"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\atlas_products\BookEntityListBuilder",
 *     "views_data" = "Drupal\atlas_products\Entity\BookEntityViewsData",
 *     "translation" = "Drupal\atlas_products\BookEntityTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\atlas_products\Form\BookEntityForm",
 *       "add" = "Drupal\atlas_products\Form\BookEntityForm",
 *       "edit" = "Drupal\atlas_products\Form\BookEntityForm",
 *       "delete" = "Drupal\atlas_products\Form\BookEntityDeleteForm",
 *     },
 *     "access" = "Drupal\atlas_products\BookEntityAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\atlas_products\BookEntityHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "book_entity",
 *   data_table = "book_entity_field_data",
 *   translatable = TRUE,
 *   admin_permission = "administer book entity entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/book_entity/{book_entity}",
 *     "add-form" = "/admin/structure/book_entity/add",
 *     "edit-form" = "/admin/structure/book_entity/{book_entity}/edit",
 *     "delete-form" = "/admin/structure/book_entity/{book_entity}/delete",
 *     "collection" = "/admin/structure/book_entity",
 *   },
 *   field_ui_base_route = "book_entity.settings"
 * )
 */
class BookEntity extends ContentEntityBase implements BookEntityInterface {
  
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
  public function getAuthor() {
    return $this->get('author')->value;
  }
  
  /**
   * {@inheritdoc}
   */
  public function setAuthor($author) {
    $this->set('author', $author);
    return $this;
  }
  
  /**
   * {@inheritdoc}
   */
  public function getDescription() {
    return $this->get('description')->value;
  }
  
  /**
   * {@inheritdoc}
   */
  public function setDescription($description) {
    $this->set('description', $description);
    return $this;
  }
  
  /**
   * {@inheritdoc}
   */
  public function getState() {
    return $this->get('state')->value;
  }
  
  /**
   * {@inheritdoc}
   */
  public function setState($state) {
    $this->set('state', $state);
    return $this;
  }
  
  /**
   * {@inheritdoc}
   */
  public function getPrice() {
    return $this->get('price')->value;
  }
  
  /**
   * {@inheritdoc}
   */
  public function setPrice($price) {
    $this->set('price', $price);
    return $this;
  }
  
  /**
   * {@inheritdoc}
   */
  public function getQuantity() {
    return $this->get('quantity')->value;
  }
  
  /**
   * {@inheritdoc}
   */
  public function setQuantity($quantity) {
    $this->set('quantity', $quantity);
    return $this;
  }
  
  /**
   * {@inheritdoc}
   */
  public function getExpirationDate() {
    return $this->get('expiration_date')->value;
  }
  
  /**
   * {@inheritdoc}
   */
  public function setExpirationDate($expiration_date) {
    $this->set('expiration_date', $expiration_date);
    return $this;
  }
  
  /**
   * {@inheritdoc}
   */
  public function getCategory() {
    return $this->get('category');
  }
  
  /**
   * {@inheritdoc}
   */
  public function setCategory($category) {
    $this->set('category', $category);
    return $this;
  }
  
  /**
   * {@inheritdoc}
   */
  public function getImage() {
    return $this->get('image');
  }
  
  /**
   * {@inheritdoc}
   */
  public function setImage($image) {
    $this->set('image', $image);
    return $this;
  }
  
  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);
    
    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Authored by'))
      ->setDescription(t('The user ID of author of the book entity.'))
      ->setRevisionable(TRUE)
      ->setReadOnly(TRUE)
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
        'weight' => 0,
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
      ->setDescription(t('The name of the Book entity.'))
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
        'weight' => 1,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
    
    $fields['status'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Publishing status'))
      ->setDescription(t('A boolean indicating whether the Book entity is published.'))
      ->setDefaultValue(TRUE);
    
    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));
    
    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));
    
    $fields['author'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Author'))
      ->setDescription(t("Book's author."))
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
        'weight' => 2,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
    
    $fields['description'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Book description'))
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
        'weight' => 3,
        'settings' => [
          'rows' => 3,
        ],
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
    
    $fields['state'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Is new'))
      ->setDescription(t('A boolean indicating whether the book is new.'))
      ->setDefaultValue(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 4,
      ]);
    
    $fields['price'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Individual Book price'))
      ->setDescription(t('The price of one individual book'))
      ->setRequired(TRUE)
      ->setRevisionable(TRUE)
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
        'type' => 'integer',
        'weight' => 5,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
    
    $fields['quantity'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Quantity'))
      ->setDescription(t('Number of the Books with the same characteristics'))
      ->setRequired(TRUE)
      ->setRevisionable(TRUE)
      ->setSettings([
        'max_length' => 50,
        'text_processing' => 0,
      ])
      ->setDefaultValue('')
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'integer',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'integer',
        'weight' => 6,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
    
    $fields['expiration_date'] = BaseFieldDefinition::create('datetime')   //todo quitar la hora
    ->setLabel(t('Expiration date'))
      ->setDescription(t('The expiration date of the Book price.'))
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => 0,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => 7,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
  
  
    $fields['category'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel('Book category')
      ->setSetting('target_type', 'taxonomy_term')
      ->setSetting('handler', 'default:taxonomy_term')
      ->setSetting('handler_settings',
        array(
          'target_bundles' => array(
            'book_category' => 'book_category'
          )))
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => 0,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'options_select',
        'weight' => 8,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
    
    $fields['image'] = BaseFieldDefinition::create('image')
      ->setCardinality(3)
      ->setLabel('Image')
      ->setSettings([
        'file_directory' => '[date:custom:Y]-[date:custom:m]-BOOKS',
        'alt_field_required' => FALSE,
        'file_extensions' => 'png jpg jpeg',
      ])
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'default',
        'weight' => 0,
      ))
      ->setDisplayOptions('form', array(
        'label' => 'hidden',
        'type' => 'image_image',
        'weight' => 9,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);
    
    return $fields;
  }
  
}
