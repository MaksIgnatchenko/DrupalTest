<?php

namespace Drupal\edu\Services;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\search\Controller\SearchController;

/**
 * Class FindSimmilarContent.
 */
class FindSimmilarContent {

  /**
   * Symfony\Component\DependencyInjection\ContainerAwareInterface definition.
   *
   * @var \Symfony\Component\DependencyInjection\ContainerAwareInterface
   */
  protected $entityQuery;
  /**
   * Drupal\Core\Entity\EntityManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityManagerInterface
   */
  protected $entityManager;
  /**
   * Constructs a new FindSimmilarContent object.
   */
  public function __construct(ContainerAwareInterface $entity_query, EntityManagerInterface $entity_manager) {
    $this->entityQuery = $entity_query;
    $this->entityManager = $entity_manager;
  }

	public function find(string $text, string $entity_type = 'node') {
		$words = explode(' ', $text);
		for ($i = 0; $i < count($words); $i++){
			$nodeQuery = $this->entityQuery->get($entity_type);
			for ($n = 0; $n < count($words) - $i; $n++) {
				$nodeQuery->condition('title', $words[$n], 'CONTAINS');
			}
			$entityIds = $nodeQuery->execute();
			if(!empty($entityIds)) break;
		}
		$entityId = reset($entityIds);
		$entity = $this->entityManager->getStorage($entity_type)->load($entityId);
		return $entity;
	}

	public function smartSearch($text = 'test article') {
		$searchEngine = new SearchController;
		$x = 10;
	}

}
