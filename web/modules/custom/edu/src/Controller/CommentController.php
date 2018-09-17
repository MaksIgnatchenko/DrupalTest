<?php

namespace Drupal\edu\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\edu\Services\CommentManager;
use Drupal\node\NodeInterface;

/**
 * Class CommentController.
 */
class CommentController extends ControllerBase {

  /**
   * Drupal\edu\Services\CommentManager definition.
   *
   * @var \Drupal\edu\Services\CommentManager
   */
  protected $eduCommentManager;

  /**
   * Constructs a new CommentController object.
   */
  public function __construct(CommentManager $edu_comment_manager) {
    $this->eduCommentManager = $edu_comment_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('edu.comment_manager')
    );
  }

  /**
   * Getsomecomments.
   *
   * @return string
   *   Return Hello string.
   */
  public function getSomeComments(NodeInterface $node = null) {
      $comments = $this->eduCommentManager->getComments($node);
      $build = [
          '#theme' => 'comment-template',
          '#comments' => $comments,
      ];
    return $build;
  }
}
