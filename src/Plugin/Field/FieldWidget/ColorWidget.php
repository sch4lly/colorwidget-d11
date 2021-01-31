<?php

namespace Drupal\colorwidget\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldWidget\OptionsWidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'options_colors' widget.
 *
 * @FieldWidget(
 *   id = "options_colors",
 *   label = @Translation("Color selection"),
 *   field_types = {
 *     "list_string",
 *   },
 *   multiple_values = TRUE
 * )
 */
class ColorWidget extends OptionsWidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);

    $options = $this->getOptions($items->getEntity());
    $selected = $this->getSelectedOptions($items);

    $element += [
      '#type' => 'colorwidget',
      '#options' => $options,
      '#default_value' => $selected ? reset($selected) : NULL,
    ];

    return $element;
  }

}
