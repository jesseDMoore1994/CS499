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
class SectionsTable extends Table
{
	public function initialize(array $config)
	{
		parent::initialize($config);

		$this->table('sections');
		$this->displayField('id');
		$this->primaryKey('id');

		$this->hasOne('Theaters', [
			'foreignKey' => 'theater_id',
			"bindingKey" => "id"
		]);

		$this->hasMany("Rows", [
			"foreignKey" => "section_id",
			"bindingKey" => "id",
		]);
	}

}