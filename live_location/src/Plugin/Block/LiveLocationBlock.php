<?php

namespace Drupal\live_location\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\live_location\Services\LiveLocationService;

/**
 * Provides a 'LiveLocationBlock' block.
 *
 * @Block(
 *  id = "live_location_block",
 *  admin_label = @Translation("Live Location block"),
 * )
 */
class LiveLocationBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Config Object.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;
  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityStorage;

  /**
   * The Location Service.
   *
   * @var \Drupal\live_location\Services\LiveLocationService
   */
  protected $liveLocation;

  /**
   * Construct function.
   */
  public function __construct(array $configuration,
  $plugin_id,
  $plugin_definition,
  ConfigFactoryInterface $config_factory,
  EntityTypeManagerInterface $entity,
  LiveLocationService $liveLocation
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->configFactory = $config_factory;
    $this->entityStorage = $entity;
    $this->liveLocation = $liveLocation;
  }

  /**
   * Create function.
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
    $configuration,
    $plugin_id,
    $plugin_definition,
    $container->get('config.factory'),
    $container->get('entity_type.manager'),
    $container->get('live_location.api')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $liveLocationConfig = $this->configFactory->get('live_location.location.settings');

    $country = $liveLocationConfig->get('country');
    $city = $liveLocationConfig->get('city');

    // Get current date time according select timezone in ACF.
    $currentDateTime = $this->liveLocation->getCurrentTimming();

    $build = [];
    $build['#cache']['max-age'] = 0;
    $build['#theme'] = 'live_location_block';
    $build['#country'] = $country;
    $build['#city'] = $city;
    $build['#dateTime'] = $currentDateTime;

    return $build;

  }

}
