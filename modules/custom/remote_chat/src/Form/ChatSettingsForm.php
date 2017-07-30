<?php

namespace Drupal\remote_chat\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ChatSettingsForm.
 *
 * @package Drupal\remote_chat\Form
 */
class ChatSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'remote_chat.chatsettings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'chat_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('remote_chat.chatsettings');
    
    $group = "chat";
    
    $form[$group] = [
      '#type' => 'details',
      '#title' => $this->t('Chat'),
      '#open' => TRUE,
    ];
  
    $form[$group]['visible'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Mostrar siempre'),
      '#description' => $this->t('Permite que el icono del chat este siempre visible'),
      '#default_value' => $config->get('visible'),
    ];
  
    $form[$group]['remote_script'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Remote script'),
      '#description' => $this->t('Habilitar en caso de tener el script en un cdn'),
      '#default_value' => $config->get('remote_script'),
    ];
    
    $form[$group]['script_url'] = array(
      '#type' => 'textfield',
      '#title' => $this->t("Ingrese la ruta cdn"),
      '#default_value' =>$config->get('script_url'),
      '#states' => array(
        'visible' => array(
          ':input[name="remote_script"]' => array('checked' => TRUE),
        ),
      ),
    );
  
    $form[$group]['script'] = array(
      '#type' => 'textarea',
      '#title' => $this->t("Ingrese el valor del script a incluir"),
      '#default_value' =>$config->get('script'),
      '#states' => array(
        'invisible' => array(
          ':input[name="remote_script"]' => array('checked' => TRUE),
        ),
      ),
    );
    
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
  
    $this->config('remote_chat.chatsettings')
      ->set('visible', $form_state->getValue('visible'))
      ->set('remote_script', $form_state->getValue('remote_script'))
      ->set('script_url', $form_state->getValue('script_url'))
      ->set('script', $form_state->getValue('script'))
      ->save();
  }

}
