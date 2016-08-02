<?php
/**
 * @file
 * Contains \Drupal\frontendapi\Plugin\Block\FrontendapiCarBlock.
 */

namespace Drupal\frontendapi\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Provide a FrontendapiCarBlock plugin.
 *
 * @Block(
 *   id = "frontendapi_car_block",
 *   admin_label = @Translation("Frontendapi Car Block"),
 * )
 */
class FrontendapiCarBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['frontendapi_car_mark'] = [
      '#type' => 'select',
      '#title' => $this->t('Car mark'),
      '#options' => [
        'bmw' => $this->t('BMW'),
        'lada' => $this->t('Lada'),
      ],
      '#default_value' => isset($config['frontendapi_car_mark']) ? $config['frontendapi_car_mark'] : '',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->setConfigurationValue('frontendapi_car_mark', $form_state->getValue('frontendapi_car_mark'));
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    switch ($this->configuration['frontendapi_car_mark']) {
      case 'bmw':
        $content = $this->t('BMW was established as a business entity following a restructuring of the Rapp Motorenwerke aircraft manufacturing firm in 1917. After the end of World War I in 1918, BMW was forced to cease aircraft-engine production by the terms of the Versailles Armistice Treaty.[5] The company consequently shifted to motorcycle production as the restrictions of the treaty started to be lifted in 1923,[6] followed by automobiles in 1928–29.[7][8][9] <br />
                                The first car which BMW successfully produced and the car which launched BMW on the road to automobile production was the Dixi, based on the Austin 7 and licensed from the Austin Motor Company in Birmingham, England.<br />
                                BMW\'s first significant aircraft engine, and commercial product of any sort, was the BMW IIIa inline-six liquid-cooled engine of 1918, known for good fuel economy and high-altitude performance.[10]');
        break;

      case 'lada':
        $content = $this->t('Lada made its name in Western Europe selling large volumes of the Fiat 124-based VAZ-2101 and its many derivatives as an economy car during the 1980s, but later models were less successful.<br/>
                                Over two million VAZ-2105s were produced from 1980 to 2010.
                                The common Lada sedan and estate, sometimes known as the "Classic" in the West (VAZ 2104/2105/2107 were known as Signet in Canada, Riva in the UK, and Nova in Germany), was based on the 1966 Fiat 124 sedan and became a successful export car.');

        break;

      default:
        $content = $this->t('Sorry no info about @car', ['@car' => $this->configuration['frontendapi_car_mark']]);
    }

    $uri = drupal_get_path('module', 'frontendapi') . '/images/sales.png';

    return [
      'frontendapi_car_mark' => [
        '#markup' => '<div>' . $content . '</div>',
      ],
      'frontendapi_banner' => [
        '#theme' => 'image',
        '#uri' => $uri,
      ],
    ];
  }

}
