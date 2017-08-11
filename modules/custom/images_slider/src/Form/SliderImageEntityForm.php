<?php

namespace Drupal\images_slider\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Slider image entity edit forms.
 *
 * @ingroup images_slider
 */
class SliderImageEntityForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\images_slider\Entity\SliderImageEntity */
    $form = parent::buildForm($form, $form_state);

    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = &$this->entity;

    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Slider image entity.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Slider image entity.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.slider_image_entity.canonical', ['slider_image_entity' => $entity->id()]);
  }

}
