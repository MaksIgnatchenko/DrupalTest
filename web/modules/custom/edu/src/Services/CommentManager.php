<?php

namespace Drupal\edu\Services;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\node\NodeInterface;
use Drupal\comment\CommentInterface;

/**
 * Class CommentManager.
 */
class CommentManager {

  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityManager;
  /**
   * Drupal\Core\Session\AccountProxyInterface definition.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;
  /**
   * Constructs a new CommentManager object.
   */
  public function __construct(EntityManagerInterface $entity_manager, AccountProxyInterface $current_user) {
    $this->entityManager = $entity_manager;
    $this->currentUser = $current_user;
  }

  public function getComments(NodeInterface $node = null) {
      if ($node) {
          $commentsList = $this->entityManager->getStorage('comment')
              ->loadByProperties([
                  'entity_id' => $node->id(),
                  'uid' => $this->currentUser->id(),
                  'status' => CommentInterface::PUBLISHED
              ]);
          if (!empty($commentsList)) {
              foreach ($commentsList as $commentEntity) {
                  $comments[] = [
                      'time' => \Drupal::service('date.formatter')->format($commentEntity->getCreatedTime(), 'medium', 'd/m/Y H:i:s', $this->currentUser->getTimeZone()),
                      'title' => $commentEntity->access('view') ? $commentEntity->getSubject() : 'No permissions',
                      'body' => $commentEntity->access('view') ? $commentEntity->get('comment_body')->value : 'No permissions',
                  ];
              }
          }
          return $comments;
      }
      return [];
  }
}
