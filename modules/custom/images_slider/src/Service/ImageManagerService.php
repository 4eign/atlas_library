<?php

namespace Drupal\images_slider\Service;

use Drupal\Core\Entity\EntityTypeManager;
use Drupal\image\Entity\ImageStyle;

/**
 * Class ImageManagerService.
 */
class ImageManagerService implements ImageManagerServiceInterface{
  
  private $entityTypeManager;
  private $sliders;
  /**
   * Constructs a new ImageManagerService object.
   * @param \Drupal\Core\Entity\EntityTypeManager $entityTypeManager
   */
  public function __construct(EntityTypeManager $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }
  
  /**
   * get all images slider entities
   * @return mixed
   */
  public function getAllSliders() {
    if(!isset($this->sliders)){
      $this->loadSliders();
    }
    return $this->sliders;
  }
  
  /**
   * load images slider entities
   * @param null $slider_ids
   */
  public function loadSliders($slider_ids = NULL) {
    $this->sliders = [];
    $entity_storage = $this->entityTypeManager->getStorage('slider_image_entity');
    
    $slider_entities = $entity_storage->loadMultiple($slider_ids);
    /**
     * format response
     */
    foreach ($slider_entities as $slider_entity){
      $slider = array();
      $slider['name'] = $slider_entity->getName();
      $slider['redirect_url'] = $slider_entity->getRedirectUrl();
      
      //get images asociated to book entity
      $image_field_list  = $slider_entity->getImage();
      $image_entities = $image_field_list->referencedEntities();
      foreach ($image_entities as $image){
        $original_image = $image->get('uri')->value;
        $style = ImageStyle::load('image_slider_1200x400');  // Load the image style configuration entity.
        $destination = $style->buildUri($original_image);
        $style->createDerivative($original_image, $destination);
        $url = $style->buildUrl($original_image);
        $slider['images'][$image->id()]['uri'] = $url;
        
      }
      unset($image_entities);
      
      array_push($this->sliders,$slider);
      unset($slider);
    }
  }

}
