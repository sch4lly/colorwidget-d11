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
      '#type' => 'radios',
      '#options' => $options,
      '#default_value' => $selected ? reset($selected) : NULL,
    ];

    foreach ($element['#options'] as $key => $title) {
      if (strpos($title, '/') !== FALSE) {
        [$title, $color] = explode('/', $title);
        $this->sanitizeLabel($title);
        $element['#options'][$key] = $title;
        $element[$key]['#attributes']['class'][] = "color-name--{$key}";
        if (substr($color, 1) != '#') {
          $element[$key]['#attributes']['class'][] = "color-css--{$color}";
        }
        if ($color != 'transparent') {
          $element[$key]['#attributes']['style'] = "background:{$color};";
        }
      }
    }

    $element['#attached']['library'][] = 'colorwidget/element.colorwidget';
    return $element;
  }

}
