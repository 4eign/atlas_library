<?php

namespace Drupal\selfcare_chat\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class ChatSettingsForm.
 *
 * @package Drupal\selfcare_chat\Form
 */
class ChatSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'selfcare_chat.chatsettings',
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
    $config = $this->config('selfcare_chat.chatsettings');
    
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
  
    $form[$group]['inline_script'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Inline script'),
      '#description' => $this->t('Deshabilite en caso que tenga el valor del script'),
      '#default_value' => $config->get('inline_script'),
    ];
    
    $form[$group]['script_url'] = array(
      '#type' => 'textfield',
      '#title' => $this->t("Ingrese la url del script a incluir"),
      '#default_value' =>$config->get('script_url'),
      '#states' => array(
        'visible' => array(
          ':input[name="inline_script"]' => array('checked' => TRUE),
        ),
      ),
    );
  
    $form[$group]['script'] = array(
      '#type' => 'textarea',
      '#title' => $this->t("Ingrese el valor del script a incluir"),
      '#default_value' =>$config->get('script'),
      '#states' => array(
        'invisible' => array(
          ':input[name="inline_script"]' => array('checked' => TRUE),
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
  
    $this->config('selfcare_chat.chatsettings')
      ->set('visible', $form_state->getValue('visible'))
      ->set('inline_script', $form_state->getValue('inline_script'))
      ->set('script_url', $form_state->getValue('script_url'))
      ->set('script', $form_state->getValue('script'))
      ->save();
  }

}
