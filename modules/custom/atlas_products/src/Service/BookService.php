<?php

namespace Drupal\atlas_products\Service;

use Drupal\Core\Entity\Query\QueryInterface;

/**
 * Class BookService.
 */
class BookService implements BookServiceInterface {

  private $entityQuery;
  
  /**
   * Constructs a new BookService object.
   * @param \Drupal\Core\Entity\Query\QueryInterface $entityQuery
   */
  public function __construct(QueryInterface $entityQuery) {
    $this->entityQuery = $entityQuery;
  }
  
  public function getAllBooks() {
    $this->entityQuery->get('book_entity');
  }

}
