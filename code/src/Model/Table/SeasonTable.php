<?php
namespace App\Model\Table;

use App\Model\Entity\Ticket;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class SeasonsTable extends Table {
	public function initialize(array $config) {
		parent::initialize($config);

		$this->table('seasons');
		$this->displayField('id');
		$this->primaryKey('id');

		$this->hasMany('Tickets', [
			'foreignKey' => 'season_id',
			'bindingKey' => 'id'
		]);
	}
}