<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @since         3.0.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace TestApp\Model\Table;

use Cake\ORM\Table;

/**
 * Tag table class
 *
 */
class TagsTable extends Table {

	public function initialize(array $config) {
		$this->belongsTo('authors');
		$this->belongsToMany('articles');
		$this->hasMany('ArticlesTags', ['propertyName' => 'extraInfo']);
	}
}
