<?php

namespace Drupal\atlas_products\Service;

use Drupal\node\Entity\Node;

/**
 * Class ProductsListService.
 *
 * @package Drupal\atlas_products\Service
 */
class ProductsListService implements ProductsListServiceInterface {

  /**
   * Constructs a new ProductsListService object.
   */
  public function __construct() {

  }

/**
*
*return all books ids
*/
  public function getAllBooksIds()
  {
  	$query = \Drupal::service('entity.query')
      ->get('node')
      ->condition('type', 'libro');
 	  $entity_ids = $query->execute();

 	return $entity_ids;
  }

  /**
  *
  * return all books entities
  */
  public function getAllBooks()
  {
    $nids = $this->getAllBooksIds();
    $entities = Node::loadMultiple($nids);
    unset($nids);

    $book=array();
    $books= array();

    foreach ($entities as $key => $entity) {
      foreach ($entity as $key2 => $field) {
        foreach ($field as $key3 => $value) {
          if ($key2 == 'field_imagen') {
            $book[$key2] = $value;
          }else{
            $book[$key2] = $value->value;
          }
        }
      }
      array_push($books, $book);
    }
    unset($entities);
    unset($book);

    return $books;
    //return $entities;
  }

}
