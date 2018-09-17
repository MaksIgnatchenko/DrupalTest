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
        $query = \Drupal\search_api\Entity\Index::load('default_index')->query();
        $query->addCondition('search_api_language', 'en');
        $query->keys('test article');
        $query->range(0, 25);
        $data = $query->execute();
        $results = $data->getResultItems();
        $entities = [];
        foreach($results as $result) {
            $entities[] = $result->getOriginalObject()->get('nid')->value;
        }
        $entityId = reset($entities);
        $entity = $this->entityManager->getStorage('node')->load($entityId);
        return $entity;
    }

}
