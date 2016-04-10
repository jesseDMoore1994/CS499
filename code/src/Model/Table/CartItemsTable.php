<?php
namespace App\Model\Table;

use App\Model\Entity\Ticket;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tickets Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Customers
 */
class CartItemsTable extends Table
{
	public function initialize(array $config)
	{
		parent::initialize($config);

		$this->table('cart_items');
		$this->displayField('id');
		$this->primaryKey('id');

		$this->hasOne('Seats', [
			'foreignKey' => 'id',
			'bindingKey' => 'seat_id'
		]);

		$this->hasOne('Performances', [
			'foreignKey' => 'id',
			'bindingKey' => 'performance_id'
		]);
	}

}