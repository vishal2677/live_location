<?php

namespace Drupal\live_location\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LiveLocationService.
 */
class LiveLocationService implements LiveLocationServiceInterface {

  /**
   * Drupal\Core\DependencyInjection\ContainerBuilder definition.
   *
   * @var \Drupal\Core\DependencyInjection\ContainerBuilder
   */
  protected $container;

  /**
   * Drupal\Core\Entity\EntityTypeManager definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  private $entityTypeManager;

  /**
   * Drupal\Core\Config\ConfigFactory definition.
   *
   * @var \Drupal\Core\Config\ConfigFactory
   */
  private $configFactory;

  /**
   * Drupal\Core\Config\Config|\Drupal\Core\Config\ImmutableConfig definition.
   *
   * @var \Drupal\Core\Config\Config|\Drupal\Core\Config\ImmutableConfig
   */
  private $liveLocationConfig;

  /**
   * Drupal\Core\Logger\LoggerChannel definition.
   *
   * @var \Drupal\Core\Logger\LoggerChannel
   */
  private $loggerChanel;

  /**
   * Constructs a new LiveLocationService object.
   */
  public function __construct(ContainerInterface $container) {
    $this->container = $container;
    $this->entityTypeManager = $container->get('entity_type.manager');
    $this->configFactory = $container->get('config.factory');
    $this->$liveLocationConfig = $this->configFactory->get('live_location.location.settings');
    $this->loggerChanel = $container->get('logger.channel.live_location');
  }

  /**
   * {@inheritdoc}
   */
  public function getCurrentTimming() {

    // Get timezone value from ACF form.
    $timezone = $this->$liveLocationConfig->get('timezone');
    // Get Cuurent Datetime value.
    $currentDate = date('Y-m-d h:i:s');
    // Set datetime with new timezone.
    $newDateTime = new \DateTime($currentDate, new \DateTimeZone('UTC'));
    $newDateTime->setTimezone(new \DateTimeZone($timezone));

    return $newDateTime->format('jS M Y - h:i A');
  }

}
