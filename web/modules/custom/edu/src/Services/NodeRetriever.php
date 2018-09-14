<?php

namespace Drupal\edu\Services;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Class NodeRetriever.
 */
class NodeRetriever {

	/**
	* Drupal\Core\Entity\EntityTypeManagerInterface definition.
	*
	* @var \Drupal\Core\Entity\EntityTypeManagerInterface
	*/
	protected $nodeTypeManager;

	/**
	* Constructs a new NodeRetriever object.
	*/
	public function __construct(EntityTypeManagerInterface $entity_type_manager) {
		$this->nodeTypeManager = $entity_type_manager->getStorage('node');
	}

	public function getNodes() {
		$nodeStorage = $this->nodeTypeManager;
		$startDay  =  strtotime("today", REQUEST_TIME);
		$idNodes = $nodeStorage->getQuery()
			->condition('created', $startDay, '>=')
			->execute();
		if (!empty($idNodes)) {
			$nodesCollection = $this->nodeTypeManager->loadMultiple($idNodes);
			$nodes = [];
			foreach($nodesCollection as $node) {
				$nodes[] = [
					'nid' => $node->access('view') ? $node->id() : 'No permissions',
					'title' => $node->access('view') ? $node->getTitle() : 'No permissions'
				];
			}
		}
		return $nodes ?? $node = [];
	}
}
