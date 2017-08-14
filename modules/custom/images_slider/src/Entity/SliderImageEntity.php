<?php

namespace Drupal\images_slider\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Slider image entity entity.
 *
 * @ingroup images_slider
 *
 * @ContentEntityType(
 *   id = "slider_image_entity",
 *   label = @Translation("Slider image entity"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\images_slider\SliderImageEntityListBuilder",
 *     "views_data" = "Drupal\images_slider\Entity\SliderImageEntityViewsData",
 *     "translation" = "Drupal\images_slider\SliderImageEntityTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\images_slider\Form\SliderImageEntityForm",
 *       "add" = "Drupal\images_slider\Form\SliderImageEntityForm",
 *       "edit" = "Drupal\images_slider\Form\SliderImageEntityForm",
 *       "delete" = "Drupal\images_slider\Form\SliderImageEntityDeleteForm",
 *     },
 *     "access" = "Drupal\images_slider\SliderImageEntityAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\images_slider\SliderImageEntityHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "slider_image_entity",
 *   data_table = "slider_image_entity_field_data",
 *   translatable = TRUE,
 *   admin_permission = "administer slider image entity entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/slider_image_entity/{slider_image_entity}",
 *     "add-form" = "/admin/structure/slider_image_entity/add",
 *     "edit-form" = "/admin/structure/slider_image_entity/{slider_image_entity}/edit",
 *     "delete-form" = "/admin/structure/slider_image_entity/{slider_image_entity}/delete",
 *     "collection" = "/admin/structure/slider_image_entity",
 *   },
 *   field_ui_base_route = "slider_image_entity.settings"
 * )
 */
class SliderImageEntity extends ContentEntityBase implements SliderImageEntityInterface {

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
  public function getRedirectUrl() {
    return $this->get('redirect_url')->value;
  }
  
  /**
   * {@inheritdoc}
   */
  public function setRedirectUrl($redirectUrl) {
    $this->set('redirect_url', $redirectUrl);
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
      ->setDescription(t('The user ID of author of the Slider image entity entity.'))
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
      ->setLabel(t('Nombre'))
      ->setDescription(t('Nombre de la entidad imagen del slider.'))
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
  
    $fields['image'] = BaseFieldDefinition::create('image')
      ->setCardinality(5)
      ->setLabel('Imagen')
      ->setSettings([
        'file_directory' => '[date:custom:Y]-[date:custom:m]-slider-images',
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
  
    $fields['redirect_url'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Url de redireccion'))
      ->setDescription(t('Url de redireccion al dar click en la imagen'))
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
      ->setDescription(t('A boolean indicating whether the Slider image entity is published.'))
      ->setDefaultValue(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

}
