<?php

namespace Drupal\atlas_products\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'BooksListBlock' block.
 *
 * @Block(
 *  id = "books_list_block",
 *  admin_label = @Translation("Lista de libros"),
 * )
 */
class BooksListBlock extends BlockBase {
  
  
  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'title' => $this->t('Lista de libros'),
      'filters_fields' =>  [
        'filter1' => ['title' => $this->t("Autor"), 'id' => 'author_filter', 'show' => 1, 'weight' => 1, 'class' => '1-columns', 'type' => 'text_field', 'validate_length' => 145, 'autocomplete' => TRUE],
        'filter2' => ['title' => $this->t("Título"), 'id' => 'title_filter', 'show' => 1,'weight' => 2, 'class' => '1-columns', 'type' => 'text_field', 'validate_length' => 200, 'autocomplete' => TRUE],
        'filter3' => ['title' => $this->t("Descripción"), 'id' => 'description_filter', 'show' => 1, 'weight' => 3, 'class' => '1-columns', 'type' => 'text_field', 'validate_length' => 300],
        'filter4' => ['title' => $this->t("Estado"),'id' => 'status_filter', 'show' => 1, 'weight' => 4, 'class' => '1-columns', 'type' => 'text_field', 'validate_length' => 200],
      ],
      'content_fields' =>  [
        'field1' => ['title' => $this->t("Autor"), 'id' => 'field_autor', 'layout' => 'destacado', 'show' => 1 ],
        'field2' => ['title' => $this->t("Título"), 'id' => 'field_title', 'layout' => 'destacado', 'show' => 1 ],
        'field3' => ['title' => $this->t("Descripción"), 'id' => 'body', 'layout' => 'destacado', 'show' => 1 ],
        'field4' => ['title' => $this->t("Precio"), 'id' => 'field_precio', 'layout' => 'destacado', 'show' => 1 ],
        'field5' => ['title' => $this->t("Estado"), 'id' => 'field_libro_nuevo', 'layout' => 'destacado', 'show' => 1 ],
      ]
    ] + parent::defaultConfiguration();
  
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
  
    /**
     * filters
     */
    $form['options'] = array(
      '#type' => 'details',
      '#title' => $this->t('Options'),
      '#open' => TRUE,
    );
    
    $form['options']['filters'] = array(
      '#type' => 'table',
      '#header' => array( t('Campo'), t('Mostrar'), t('Tipo')),
      '#empty' => t('No hay elementos agregados.'),
    
    );
    
    $fields = $this->configuration['filters_fields'];
    
    foreach ($fields as $id => $entity) {
      
      $form['options']['filters'][$id]['label'] = array(
        '#plain_text' => $entity['title'],
      );
      
      $form['options']['filters'][$id]['show'] = array(
        '#type' => 'checkbox',
        '#default_value' => $entity['show'],
      );
  
      $form['options']['filters'][$id]['type'] = array(
        '#type' => 'select',
        '#options' => array(
          'text_field' => $this->t('campo de texto'),
          'text_area' => $this->t('Area de texto'),
          'check_box' => $this->t('Chekbox'),
          'select' => $this->t('Lista desplegable'),
        ),
        '#default_value' => $entity['type'],
      );
    }
  
    /**
     * fields
     */
    $form['options']['fields'] = array(
      '#type' => 'table',
      '#header' => array( t('Campo'), t('Mostrar'), t('Estilo')),
      '#empty' => t('No hay elementos agregados.'),
  
    );
  
    $fields = $this->configuration['content_fields'];
  
    foreach ($fields as $id => $entity) {
    
      $form['options']['fields'][$id]['label'] = array(
        '#plain_text' => $entity['title'],
      );
    
      $form['options']['fields'][$id]['show'] = array(
        '#type' => 'checkbox',
        '#default_value' => $entity['show'],
      );
    
      $form['options']['fields'][$id]['layout'] = array(
        '#type' => 'select',
        '#options' => array(
          'destacado' => $this->t('Destacado'),
          '1-columns' => $this->t('Una columna (Legal)'),
          '2-columns' => $this->t('Dos columnas'),
        ),
        '#default_value' => $entity['layout'],
      );
    }
    
    $form['actions'] = array(
      '#type' => 'details',
      '#title' => $this->t('Actions'),
      '#open' => TRUE,
    );
    $form['actions']['show_payment_button'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t("Mostrar boton pagar"),
      '#default_value' => $this->configuration['show_payment_button'],
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['title'] = $form_state->getValue('title');
    $this->configuration['filters_fields'] = $form_state->getValue(['options','filters']);
    $this->configuration['content_fields'] = $form_state->getValue(['options','fields']);
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $uuid = $this->configuration['uuid'];
  
    $filters = $this->configuration['filters_fields'];
  
    uasort($filters, array('Drupal\Component\Utility\SortArray', 'sortByWeightElement'));
  
    $data = array();
    foreach ($filters as $key_field => $field){
      if($field['show'] == 1){
        $data[$key_field]['label'] = $field['title'];
        $classes = [$field['id'], $field['class']];
        $data[$key_field]['class'] = implode(" ", $classes);
        $data[$key_field]['id'] = $field['id'];
        $data[$key_field]['type'] = $field['type'];
        unset($classes);
      } else {
        unset($filters[$key_field]);
      }
    }
  
    $block_config = array(
      'url' => '/api/product/book?_format=json',
      'block_config' => $this->configuration,
    );

    $build = array(
      '#theme' => 'books_list',
      '#uuid' => $uuid,
      '#filters' => $data,
      '#config' => $this->configuration,
      '#attached' => array(
        'library' =>  array(
          'atlas_products/books'
        ),
      ),
    );

    $build['#attached']['drupalSettings']['booksListBlockConfig'][$uuid] = $block_config;

    $build['#cache']['max-age'] = 0;
  
    return $build;
  }

}
