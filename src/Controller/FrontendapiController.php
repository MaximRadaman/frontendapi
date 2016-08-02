<?php
/**
 * @file
 * Contains \Drupal\frontendapi\Controller\FrontendapiController.
 */

namespace Drupal\frontendapi\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\Core\Link;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Routing\TrustedRedirectResponse;

/**
 * Class FrontendapiController.
 *
 * @package Drupal\frontendapi\Controller.
 */
class FrontendapiController extends ControllerBase {

  /**
   * Get car list page.
   */
  public function carList() {
    $car_list[] = Link::fromTextAndUrl($this->t('BMW'), Url::fromRoute('frontendapi.cars.car', ['car' => 'bmw']));
    $car_list[] = Link::fromTextAndUrl($this->t('Lada'), Url::fromRoute('frontendapi.cars.car', ['car' => 'lada']));

    $output['car_list'] = [
      '#theme' => 'item_list',
      '#items' => $car_list,
      '#title' => t('Car list'),
    ];

    return $output;
  }

  /**
   * Get specific car page.
   */
  public function car($car) {

    $block = \Drupal::service('plugin.manager.block')
      ->createInstance('frontendapi_car_block', ['frontendapi_car_mark' => strtolower(trim($car))])
      ->build();

    $build['#title'] = strtoupper(strtolower($car));
    $build['car'] = $block;

    return $build;
  }

  /**
   * Get car list in Json format.
   */
  public function carListJson() {
    $response = new JsonResponse();
    $response->setData([
        'cars' => [
          'bmw' => [
            'name' => $this->t('BMW'),
          ],
          'lada' => [
            'name' => $this->t('Lada')
          ],
        ]
      ]
    );
    return $response;
  }

  /**
   * Redirect to onliner.
   */
  public function responseRedirectOnliner() {
    $response = new TrustedRedirectResponse('http://onliner.by/');
    return $response;
  }

  /**
   * BMW club in Belarus.
   */
  public function bmwClubInfo() {
    return [
      'bmw_club_info' => [
        '#type' => 'frontendapi_address_element',
        '#country' => $this->t('Belarus'),
        '#link_text' => 'BMW club Belarus',
        '#link_url' => 'http://bmwclub.by',
      ],
    ];
  }

}
