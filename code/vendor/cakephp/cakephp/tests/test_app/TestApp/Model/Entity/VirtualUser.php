<?php

namespace TestApp\Model\Entity;

use Cake\ORM\Entity;

class VirtualUser extends Entity {

	protected $_virtual = [
		'bonus'
	];

	protected function _getBonus() {
		return 'bonus';
	}
}
