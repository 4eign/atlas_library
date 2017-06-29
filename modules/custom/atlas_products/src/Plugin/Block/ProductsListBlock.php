<?php

namespace Drupal\atlas_products\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'ProductsListBlock' block.
 *
 * @Block(
 *  id = "products_list_block",
 *  admin_label = @Translation("Lista de productos"),
 * )
 */
class ProductsListBlock extends BlockBase {


  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'title' => $this->t('Lista de Productos'),
      'table_fields' =>  [
        'show_author' => ['title' => $this->t("Autor"), 'service_field' => 'field_autor', 'layout' => 'destacado', 'show' => 1 ],
        'show_title' => ['title' => $this->t("Título"), 'service_field' => 'field_title', 'layout' => 'destacado', 'show' => 1 ],
        'show_description' => ['title' => $this->t("Descripción"), 'service_field' => 'body', 'layout' => 'destacado', 'show' => 1 ],
        'show_price' => ['title' => $this->t("Precio"), 'service_field' => 'field_precio', 'layout' => 'destacado', 'show' => 1 ],
        'show_status' => ['title' => $this->t("Estado"), 'service_field' => 'field_libro_nuevo', 'layout' => 'destacado', 'show' => 1 ],
      ]
    ] + parent::defaultConfiguration();

 }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {

    //TODO paginacion
    
    $form['options'] = array(
      '#type' => 'details',
      '#title' => $this->t('Options'),
      '#open' => TRUE,
    );
    
    $form['options']['fields'] = array(
      '#type' => 'table',
      '#header' => array( t('Campo'), t('Mostrar'), t('Estilo')),
      '#empty' => t('No hay elemntos agregados.'),
    
    );
    
    $fields = $this->configuration['table_fields'];
    
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
    $this->configuration['table_fields'] = $form_state->getValue(['options','fields']);
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $uuid = $this->configuration['uuid'];
  
    $block_config = array(
      'url' => '/api/products?_format=json',
      'block_config' => $this->configuration,
    );

    $build = array(
      '#theme' => 'products_list',
      '#uuid' => $uuid,
      '#config' => $this->configuration,
      '#attached' => array(
        'library' =>  array(
          'atlas_products/products'
        ),
      ),
    );

    $build['#attached']['drupalSettings']['blockConfig'][$uuid] = $block_config;

    $build['#cache']['max-age'] = 0;
  
    return $build;
  }

}
