<?php
/**
 * @file
 * Contains \Drupal\frontendapi\Element\FrontendapiAddressElement.
 */

namespace Drupal\frontendapi\Element;

use Drupal\Core\Render\Element\RenderElement;
use Drupal\Core\Url;

/**
 * Provide FrontendapiAddressElement.
 *
 * @RenderElement("frontendapi_address_element")
 */
class FrontendapiAddressElement extends RenderElement {

  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);
    return [
      '#theme' => 'frontendapi_address_element',
      '#country' => 'Default country',
      '#link_text' => 'Default text link',
      '#link_url' => 'http://drupal.org',
      '#pre_render' => [
        [$class, 'preRenderFrontendapiAddressElement'],
      ],
    ];
  }

  /**
   * Prepare the render array for the template.
   */
  public static function preRenderFrontendapiAddressElement($element) {

    $element['country'] = [
      '#markup' => $element['#country']
    ];
    $element['link'] = [
      '#type' => 'link',
      '#title' => $element['#link_text'],
      '#url' => Url::fromUri($element['#link_url']),
    ];

    // Create a variable.
    $element['#time'] = time();

    return $element;
  }

}
