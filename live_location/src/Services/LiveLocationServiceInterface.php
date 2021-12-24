<?php

namespace Drupal\live_location\Services;

/**
 * Interface LiveLocationServiceInterface.
 */
interface LiveLocationServiceInterface {

  /**
   * Fetch current timming using timezone.
   *
   * @return string
   *   Current Timming.
   */
  public function getCurrentTimming();

}
