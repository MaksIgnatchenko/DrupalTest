<?php

namespace Drupal\edu\Services;

use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Datetime\DateFormatterInterface;


/**
 * Class CustomTime.
 */
class CustomTime {

    private $dateTime;

    private const EN_WEEKEND_DAYS = [6, 7];
    private const WEEKEND_DAYS = [7, 0];

    protected $language_manager;

    /**
     * Drupal\Core\Session\AccountProxyInterface definition.
     *
     * @var \Drupal\Core\Session\AccountProxyInterface
     */
    protected $currentUser;

    protected $dateFormatter;

    /**
     * Constructs a new CustomTime object.
     */
    public function __construct(LanguageManagerInterface $language_manager, AccountProxyInterface $current_user, DateFormatterInterface $dateFormatter) {
        $this->dateTime = new \DateTime();
        $this->language_manager = $language_manager;
        $this->currentUser = $current_user;
        $this->dateFormatter = $dateFormatter;
    }

    public function getCurrentTime($format = 'd/m/Y H:i:s') {
        $userTimeZone = \Drupal::currentUser()->getTimeZone() ?? date_default_timezone_get();
        $timeZone = new \DateTimeZone($userTimeZone);
        $this->dateTime->setTimezone($timeZone);
        return  $this->dateTime->format($format);
    }

    public function isDayOff($date = 'today') {
        $current_language = $this->language_manager->getCurrentLanguage()->getId();
        $weekendDays = ($current_language == 'en') ? self::EN_WEEKEND_DAYS : self::WEEKEND_DAYS;
        $numberOfDay = $this->dateFormatter->format(REQUEST_TIME, 'custom', 'w', $this->currentUser->getTimeZone());
        if(in_array($numberOfDay, $weekendDays)) {
            return true;
        }
        return false;
    }
}
