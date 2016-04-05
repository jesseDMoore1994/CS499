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
class PerformancesTable extends Table
{
	public function initialize(array $config)
	{
		parent::initialize($config);

		$this->table('performances');
		$this->displayField('id');
		$this->primaryKey('id');

		$this->hasOne('Plays', [
			'foreignKey' => 'id',
			'joinType' => 'INNER'
		]);
	}

}