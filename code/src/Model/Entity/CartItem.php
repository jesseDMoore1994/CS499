<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\I18n\Time;

class CartItem extends Entity
{
	protected $_accessible = [
		'*' => true,
	];
}
