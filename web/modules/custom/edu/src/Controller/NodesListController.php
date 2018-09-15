<?php

namespace Drupal\edu\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class NodesListController.
 */
class NodesListController extends ControllerBase {

    /**
     * Get all node in json format
     *
     * @return string
     *   Return Hello string.
     */
    public function getAllJson() {
        $nodes = \Drupal::database()->select('node_field_data', 'n')
            ->fields('n', ['nid', 'type', 'title'])
            ->execute()
            ->fetchAll();
        return new JsonResponse($nodes);
    }

}
