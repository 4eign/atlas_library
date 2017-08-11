<?php

namespace Drupal\atlas_products\Service;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\image\Entity\ImageStyle;


/**
 * Class BookService.
 */
class BookService implements BookServiceInterface {

  private $entity_type_manager;
  private $books;
  
  /**
   * Constructs a new BookService object.
   * @param \Drupal\Core\Entity\EntityTypeManager $entityTypeManager
   */
  public function __construct(EntityTypeManager $entityTypeManager) {
    $this->entity_type_manager = $entityTypeManager;
  }
  
  /**
   * get all book entities
   * @return mixed
   */
  public function getAllBooks() {
    if(!isset($this->books)){
      $this->loadBooks();
    }
    return $this->books;
  }
  
  /**
   * load books entities
   * @param null $books_ids
   */
  public function loadBooks($books_ids = NULL) {
    $this->books = [];
    $entity_storage = $this->entity_type_manager->getStorage('book_entity');
    
    $books_entities = $entity_storage->loadMultiple($books_ids);
    /**
     * format response
     */
    foreach ($books_entities as $book_entity){
      $book = array();
      $book['name'] = $book_entity->getName();
      $book['author'] = $book_entity->getAuthor();
      $book['description'] = $book_entity->getDescription();
      $book['state'] = $book_entity->getState();
      $book['price'] = $book_entity->getPrice();
      $book['quantity'] = $book_entity->getQuantity();
      $book['expirationDate'] = $book_entity->getExpirationDate();
      
      //get categories associated to book entity
      $category_field_list = $book_entity->getCategory();
      $term_entities = $category_field_list->referencedEntities();
      foreach ($term_entities as $taxonomy_term){
        $book['category']['name'] = $taxonomy_term->getName();
      }
      unset($term_entities);
      
      //get images asociated to book entity
      $image_field_list  = $book_entity->getImage();
      $image_entities = $image_field_list->referencedEntities();
      foreach ($image_entities as $image){
        /*  TODO ver si es necesario enviar todos estos parametros
        $cont = 0;
        $image_2 = array(
          'target_id' => $image->get('fid')->value,
          'alt' => 'testalt',
          'title' => 'testtitle',
          'width' => '',
          'height' => '',
          'target_uuid' => $image->get('uuid')->value,
          'url' => $image->get('uri')->value
        );
        
        $book['image'][$cont]['url'] = $image->get('uri')->value;
        $cont++;
        */
        //$book['image']['uri'] = file_create_url($image->get('uri')->value);
        /**
         * create a new image with style
         */
        $original_image = $image->get('uri')->value;
        $style = ImageStyle::load('book_card_image_207x309');  // Load the image style configuration entity.
        $destination = $style->buildUri($original_image);
        $style->createDerivative($original_image, $destination);
        $url = $style->buildUrl($original_image);
        $book['image']['uri'] = $url;
      }
      unset($image_entities);
      unset($cont);
        
      array_push($this->books,$book);
      unset($book);
    }
  }
  
  /**
   * @param $filters
   * @return array
   */
  public function loadBooksByFilters($filters) {
    $this->books = [];
    $entity_storage = $this->entity_type_manager->getStorage('book_entity');
    $query = $entity_storage->getQuery();
    foreach ($filters as $filter => $value){
      $query->condition($filter, $value, 'CONTAINS');
    }
    
    $books_ids = $query->execute();
    $this->loadBooks($books_ids);
  
    return $this->books;
  }
  
  /**
   * @param $start
   * @param $end
   * @return array
   */
  public function loadBooksByRange($start, $end) {
    $this->books = [];
    $entity_storage = $this->entity_type_manager->getStorage('book_entity');
    $query = $entity_storage->getQuery();
    $query->range($start, $end);
    $books_ids = $query->execute();
    $this->loadBooks($books_ids);
    
    return $this->books;
  }
  
}
