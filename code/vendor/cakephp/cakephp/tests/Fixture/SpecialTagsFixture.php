<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         3.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * A fixture for a join table containing additional data
 *
 */
class SpecialTagsFixture extends TestFixture {

	/**
	 * fields property
	 *
	 * @var array
	 */
	public $fields = [
		'id' => ['type' => 'integer'],
		'article_id' => ['type' => 'integer', 'null' => false],
		'tag_id' => ['type' => 'integer', 'null' => false],
		'highlighted' => ['type' => 'boolean', 'null' => true],
		'highlighted_time' => ['type' => 'timestamp', 'null' => true],
		'author_id' => ['type' => 'integer', 'null' => true],
		'_constraints' => [
			'primary' => ['type' => 'primary', 'columns' => ['id']],
			'UNIQUE_TAG2' => ['type' => 'unique', 'columns' => ['article_id', 'tag_id']]
		]
	];

	/**
	 * records property
	 *
	 * @var array
	 */
	public $records = [
		['article_id' => 1, 'tag_id' => 3, 'highlighted' => false, 'highlighted_time' => null, 'author_id' => 1],
		['article_id' => 2, 'tag_id' => 1, 'highlighted' => true, 'highlighted_time' => '2014-06-01 10:10:00', 'author_id' => 2]
	];
}
