<?php

namespace Drupal\edu\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\edu\Services\NodeRetriever;

/**
 * Class NodeRetieverController.
 */
class NodeRetieverController extends ControllerBase {

  /**
   * Drupal\edu\Services\NodeRetriever definition.
   *
   * @var \Drupal\edu\Services\NodeRetriever
   */
  protected $eduNodeRetriever;

  /**
   * Constructs a new NodeRetieverController object.
   */
  public function __construct(NodeRetriever $edu_node_retriever) {
    $this->eduNodeRetriever = $edu_node_retriever;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('edu.node_retriever')
    );
  }

  /**
   * getTodayNodes.
   *
   * @return string
   *   Return Hello string.
   */
  public function getTodayNodes() {
  	$rows = $this->eduNodeRetriever->getNodes();
  	$build['today_nodes'] = [
		'#type' => 'table',
		'#header' => [t('NID'), t('Title')],
		'#rows' => $rows,
		'#empty' => 'no nodes',
	];
    return $build;
  }

}
