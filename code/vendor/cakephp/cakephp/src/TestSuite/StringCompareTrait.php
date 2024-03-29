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
 * @since         3.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\TestSuite;

/**
 * Compare a string to the contents of a file
 *
 * Implementing objects are expected to modify the `$_compareBasePath` property
 * before use.
 */
trait StringCompareTrait {

	/**
	 * The base path for output comparisons
	 *
	 * Must be initialized before use
	 *
	 * @var string
	 */
	protected $_compareBasePath = '';

	/**
	 * Compare the result to the contents of the file
	 *
	 * @param string $path partial path to test comparison file
	 * @param string $result test result as a string
	 * @return void
	 */
	public function assertSameAsFile($path, $result) {
		$path = $this->_compareBasePath . $path;

		$expected = file_get_contents($path);
		$this->assertTextEquals($expected, $result);
	}
}
