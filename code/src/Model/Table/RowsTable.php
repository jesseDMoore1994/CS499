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
class RowsTable extends Table
{
	public function initialize(array $config)
	{
		parent::initialize($config);

		$this->table('rows');
		$this->displayField('id');
		$this->primaryKey('id');

		$this->belongsTo('Theaters', [
			'foreignKey' => 'theater_id',
			'bindingKey' => 'id'
		]);

		$this->hasOne('Sections', [
			'foreignKey' => 'id',
			'bindingKey' => 'section_id',
			'propertyName' => "section"
		]);

		$this->hasMany("Seats", [
			'foreignKey' => 'row_id',
			'bindingKey' => 'id',
		]);
	}

}