<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class Seat extends Entity
{
	protected $_accessible = [
		'*' => true,
	];
}
