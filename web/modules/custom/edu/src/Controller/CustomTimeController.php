<?php

namespace Drupal\edu\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\edu\Services\CustomTime;

/**
 * Class CustomTimeController.
 */
class CustomTimeController extends ControllerBase {

  /**
   * Drupal\edu\Services\CustomTime definition.
   *
   * @var \Drupal\edu\Services\CustomTime
   */
  protected $time;

  /**
   * Constructs a new CustomTimeController object.
   */
  public function __construct(CustomTime $edu_customtime) {
    $this->time = $edu_customtime;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('edu.customtime')
    );
  }

  /**
   * Gettime.
   *
   * @return string
   *   Return Hello string.
   */
  public function getTime() {
    $dateTime = $this->time->getCurrentTime();
    $build = [
        '#type' => 'markup',
        '#markup' => $dateTime,
        '#cache' => [
            'context' => ['user'],
            'max-age' => 150,
        ],
    ];
    return $build;
  }

}
