<?php
/**
 * https://stackoverflow.com/questions/1416697/converting-timestamp-to-time-ago-in-php-e-g-1-day-ago-2-days-ago
 *
 * Created by PhpStorm.
 * User: matt
 * Date: 4/5/16
 * Time: 12:12 AM
 */

use Cake\I18n\Time;

function time_elapsed_string($ptime)
{

	$now = time();

	$a = array( 365 * 24 * 60 * 60  =>  'year',
		30 * 24 * 60 * 60  =>  'month',
		24 * 60 * 60  =>  'day',
		60 * 60  =>  'hour',
		60  =>  'minute',
		1  =>  'second'
	);
	$a_plural = array( 'year'   => 'years',
		'month'  => 'months',
		'day'    => 'days',
		'hour'   => 'hours',
		'minute' => 'minutes',
		'second' => 'seconds'
	);

	if ($ptime > $now) {

		$etime = $ptime - $now;

		foreach ($a as $secs => $str)
		{
			$d = $etime / $secs;
			if ($d >= 1)
			{
				$r = round($d);
				return 'In ' . $r . ' ' . ($r > 1 ? $a_plural[$str] : $str);
			}
		}
	} else {

		$etime = $now - $ptime;

		foreach ($a as $secs => $str)
		{
			$d = $etime / $secs;
			if ($d >= 1)
			{
				$r = round($d);
				return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
			}
		}
	}
}

function time_format($stamp) {
	return Time::createFromTimestamp($stamp);
}