<?php

namespace Drupal\edu\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\edu\Services\FindSimmilarContent;

/**
 * Class SimmilarContentController.
 */
class SimmilarContentController extends ControllerBase {

  /**
   * Drupal\edu\Services\FindSimmilarContent definition.
   *
   * @var \Drupal\edu\Services\FindSimmilarContent
   */
  protected $eduFindSimmilarContent;

  /**
   * Constructs a new SimmilarContentController object.
   */
  public function __construct(FindSimmilarContent $edu_find_simmilar_content) {
    $this->eduFindSimmilarContent = $edu_find_simmilar_content;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('edu.find_simmilar_content')
    );
  }

  /**
   * Find.
   *
   * @return string
   *   Return Hello string.
   */
  public function find() {
//  	$entity = $this->eduFindSimmilarContent->find('Test article sadasdasdasd');
	  $entity = $this->eduFindSimmilarContent->smartSearch('Test article sadasdasdasd');
	  $build = [
          '#type' => 'markup',
          '#markup' => $this->t($entity->getTitle())
      ];
    return $build;
  }

}
