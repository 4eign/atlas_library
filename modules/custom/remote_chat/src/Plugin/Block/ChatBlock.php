<?php

namespace Drupal\remote_chat\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'ChatBlock' block.
 *
 * @Block(
 *  id = "chat_block",
 *  admin_label = @Translation("Chat block"),
 * )
 */
class ChatBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
  
    $uuid = $this->configuration['uuid'];
    $chat_config = \Drupal::config('remote_chat.chatsettings');
    $chat_settings = array(
      'visible' => $chat_config->get('visible'),
      'name' => '', //TODO agregar los datos del usuario para rellenar el form del chat auto
      'user' => '', //TODO agregar los datos del usuario para rellenar el form del chat auto
    );
    
    $build = array(
      '#uuid' => $uuid,
      '#config' => $this->configuration,
      '#attached' => array(
        'library' =>  array(
          'remote_chat/chat'
        ),
      ),
    );
  
    $build['#attached']['drupalSettings']['chat'] = $chat_settings;

    return $build;
  }

}
