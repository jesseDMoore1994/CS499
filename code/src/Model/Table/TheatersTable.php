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

		$this->hasMany("Sections", [
			"foreignKey" => "theater_id",
			"bindingKey" => "id",
			"propertyName" => "sections"
		]);

		$this->hasMany("Rows", [
			"foreignKey" => "theater_id",
			"bindingKey" => "id",
			"propertyName" => "rows"
		]);

		$this->hasMany("Performances", [
			"foreignKey" => "theater_id",
			"bindingKey" => "id",
			"propertyName" => "performances"
		]);

		$this->hasMany("Seats", [
			"foreignKey" => "theater_id",
			'bindingKey' => 'id'
		]);
	}

}