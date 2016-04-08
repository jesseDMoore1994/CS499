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

		$this->belongsTo('Theaters', [
			'foreignKey' => 'theater',
			"bindingKey" => "id",
			'joinType' => 'INNER'
		]);

		$this->hasOne('Theaters', [
			'foreignKey' => 'theater_id',
			"bindingKey" => "id",
			'joinType' => 'INNER'
		]);

		$this->hasMany("Rows", [
			"foreignKey" => "section",
			"bindingKey" => "id",
		]);
	}

}