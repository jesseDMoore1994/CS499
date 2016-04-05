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
class TheatersTable extends Table
{
	public function initialize(array $config)
	{
		parent::initialize($config);

		$this->table('theaters');
		$this->displayField('id');
		$this->primaryKey('id');
	}

}