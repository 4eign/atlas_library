<?php

namespace Drupal\atlas_products\Service;

use Drupal\Core\Entity\Query\QueryInterface;

/**
 * Class BookService.
 */
class BookService implements BookServiceInterface {

  private $entity_query;
  private $books;
  
  /**
   * Constructs a new BookService object.
   * @param \Drupal\Core\Entity\Query\QueryInterface $entityQuery
   */
  public function __construct(QueryInterface $entityQuery) {
    $this->entity_query = $entityQuery;
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
   * load books array
   */
  public function loadBooks() {
    $this->books = [];
    $this->entityQuery->get('book_entity');
    $this->books = $this->entityQuery->execute();
  }
  
}
