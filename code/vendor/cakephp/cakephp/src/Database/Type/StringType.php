<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         3.1.2
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Database\Type;

use Cake\Database\Driver;
use Cake\Database\Type;
use InvalidArgumentException;
use PDO;

/**
 * String type converter.
 *
 * Use to convert string data between PHP and the database types.
 */
class StringType extends Type {

	/**
	 * Convert string data into the database format.
	 *
	 * @param mixed $value The value to convert.
	 * @param Driver $driver The driver instance to convert with.
	 * @return string|null
	 */
	public function toDatabase($value, Driver $driver) {
		if ($value === null || is_string($value)) {
			return $value;
		}

		if (is_object($value) && method_exists($value, '__toString')) {
			return $value->__toString();
		}

		if (is_scalar($value)) {
			return (string)$value;
		}

		throw new InvalidArgumentException('Cannot convert value to string');
	}

	/**
	 * Convert string values to PHP strings.
	 *
	 * @param mixed $value The value to convert.
	 * @param Driver $driver The driver instance to convert with.
	 * @return string|null
	 */
	public function toPHP($value, Driver $driver) {
		if ($value === null) {
			return null;
		}
		return (string)$value;
	}

	/**
	 * Get the correct PDO binding type for string data.
	 *
	 * @param mixed $value The value being bound.
	 * @param Driver $driver The driver.
	 * @return int
	 */
	public function toStatement($value, Driver $driver) {
		return PDO::PARAM_STR;
	}

	/**
	 * Marshalls request data into PHP strings.
	 *
	 * @param mixed $value The value to convert.
	 * @return mixed Converted value.
	 */
	public function marshal($value) {
		if ($value === null) {
			return null;
		}
		if (is_array($value)) {
			return '';
		}
		return (string)$value;
	}
}
