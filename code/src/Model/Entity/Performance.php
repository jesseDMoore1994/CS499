<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\I18n\Time;

require_once(ROOT . DS . 'vendor' . DS  . 'theater-ticket' . DS . 'time_elapsed_string.php');

class Performance extends Entity
{
	protected $_accessible = [
		'*' => true,
	];

	function timeFormatted() {
		return time_format($this->start_time);
	}

	function timeDate() {
		$time = Time::createFromTimestamp($this->start_time);
		return $time->i18nFormat('MM/dd/yyyy');
	}

	function timeHour() {
		$time = Time::createFromTimestamp($this->start_time);
		return $time->i18nFormat('G');
	}
}
