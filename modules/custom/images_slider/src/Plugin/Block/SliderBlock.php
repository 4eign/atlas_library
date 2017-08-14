<?php

namespace Drupal\images_slider\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\image\Entity\ImageStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'SliderBlock' block.
 *
 * @Block(
 *  id = "slider_block",
 *  admin_label = @Translation("Slider block"),
 * )
 */
class SliderBlock extends BlockBase implements ContainerFactoryPluginInterface{
  
  
  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManager $entityTypeManager) {
    // Store our dependency.
    $this->entityTypeManager = $entityTypeManager;
    
    // Call parent construct method.
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    
  }
  
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager')
    );
  }
  
  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
         'options' => array(
           'slider_select' => ''
         ),
        ] + parent::defaultConfiguration();

 }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
  
    $slider_image_storage = $this->entityTypeManager->getStorage('slider_image_entity');
    $slider_images_entities = $slider_image_storage->loadMultiple();
    
    $options=array();
    foreach ($slider_images_entities as $slider){
      $options[$slider->id()] = $slider->label();
    }
  
    $form['options'] = array(
      '#type' => 'details',
      '#title' => $this->t('Opciones'),
      '#open' => TRUE,
    );
    
    $form['options']['slider_select'] = [
      '#type' => 'select',
      '#title' => $this->t('Seleccione el slider que desea mostrar'),
      '#options' => $options,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['options'] = $form_state->getValue('options');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $uuid = $this->configuration['uuid'];
    
    $selected_slider = $this->configuration['options']['slider_select'];
    $slider_image_storage = $this->entityTypeManager->getStorage('slider_image_entity');
    $slider_images_entity = $slider_image_storage->load($selected_slider);
    unset($selected_slider);
    unset($slider_image_storage);
    
    $image_field_list = $slider_images_entity->getImage();
    $image_entities = $image_field_list->referencedEntities();
    
    $images = array();
    $image = array();
    foreach ($image_entities as $image_entity){
      $original_image = $image_entity->get('uri')->value;
      $style = ImageStyle::load('image_slider_1200x400');  // Load the image style configuration entity.
      $url = $style->buildUrl($original_image);
      $image['url'] = $url;
      //$image['alt'] = $image_entity->get('alt');
      array_push($images,$image);
      unset($image);
    }
    
    $block_config = array(
      'url' => '/api/slider?_format=json',
      'block_config' => $this->configuration,
    );
  
    $build = array(
      '#theme' => 'images_slider',
      '#uuid' => $uuid,
      '#images' => $images,
      '#config' => $this->configuration,
      '#attached' => array(
        'library' =>  array(
          'images_slider/slider'
        ),
      ),
    );
  
    $build['#attached']['drupalSettings']['imagesSliderBlockConfig'][$uuid] = $block_config;
  
    $build['#cache']['max-age'] = 0;
  
    return $build;
  }

}
