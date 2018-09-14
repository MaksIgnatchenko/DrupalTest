<?php

namespace Drupal\edu\Services;

/**
 * Class CustomTime.
 */
class CustomTime {

    private $dateTime;

    public function __construct() {
        $this->dateTime = new \DateTime();
    }

    public function getCurrentTime($format = 'd/m/Y H:i:s') {
        $userTimeZone = \Drupal::currentUser()->getTimeZone();
        $timeZone = new \DateTimeZone($userTimeZone);
        $this->dateTime->setTimezone($timeZone);
        return  $this->dateTime->format($format);
    }
}
