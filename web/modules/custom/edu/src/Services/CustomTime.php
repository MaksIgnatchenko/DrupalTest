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

    private const EN_WEEKEND_DAYS = [5, 6];
    private const WEEKEND_DAYS = [6, 0];

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
		return $this->dateFormatter->format(
			REQUEST_TIME,
			'custom',
			$format,
			$this->currentUser->getTimeZone()
		);
    }

    public function isDayOff($date = 'today') {
    	$timeStamp = strtotime($date);
    	if ($timeStamp === false) {
			\Drupal::logger('edu')->debug("Format of date $date is not valid");
			$timeStamp = REQUEST_TIME;
		}
        $current_language = $this->language_manager->getCurrentLanguage()->getId();
//        $weekendDays = ($current_language == 'en') ? self::EN_WEEKEND_DAYS : self::WEEKEND_DAYS;
		$configStorage = \Drupal::config('edu.settings');
		$weekendDays = ($current_language == 'en') ? $configStorage->get('en_weekends') : $configStorage->get('weekends');
        $numberOfDay = $this->dateFormatter
			->format(
				$timeStamp,
				'custom',
				'w',
				$this->currentUser->getTimeZone()
			);
        return in_array($numberOfDay, $weekendDays);
    }
}
