<?php

namespace Drupal\colorwidget\Element;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element\FormElement;

/**
 * Renders color widget.
 *
 * @FormElement("colorwidget")
 */
class ColorWidget extends FormElement {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);
    return [
      '#process' => [
        [$class, 'processFormElement'],
      ],
      '#pre_render' => [
        [$class, 'preRenderGroup'],
      ],
      '#input' => TRUE,

    ];
  }

  /**
   * Process render array.
   *
   * @param array $element
   *   Render array.
   *
   * @return array
   *   Render array.
   */
  public static function processFormElement(&$element, FormStateInterface $form_state, &$complete_form) {

    $element['colorwidget'] = [
      '#prefix' => '<div class="colorwidget">',
      '#suffix' => '</div>',
      '#type' => 'radios',
      '#required' => $element['#required'],
      '#default_value' => $element['#default_value'],
      '#title' => $element['#title']
    ];
    if (empty($element['#options'])) {
      $element['#options'] = [];
    }

    foreach ($element['#options'] as $key => $title) {
      if (strpos($title, '/') !== FALSE) {
        [$title, $color] = explode('/', $title);
        $element['colorwidget']['#options'][$key] = $title;
        $element['colorwidget'][$key]['#attributes']['class'][] = "color-name--{$key}";

        if (substr($color, 1) != '#') {
          $element['colorwidget'][$key]['#attributes']['class'][] = "color-css--{$color}";
        }

        if ($color != 'transparent') {
          $element['colorwidget'][$key]['#attributes']['style'] = "background:{$color};";
        }
      }
    }

    $element['colorwidget']['#attached']['library'][] = 'colorwidget/element.colorwidget';
    return $element;
  }

}
