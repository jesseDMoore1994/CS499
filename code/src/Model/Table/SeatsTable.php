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
class SeatsTable extends Table
{
	public function initialize(array $config)
	{
		parent::initialize($config);

		$this->table('seats');
		$this->displayField('id');
		$this->primaryKey('id');

		$this->belongsTo('Theaters', [
			'foreignKey' => 'id',
			'bindingKey' => "theater_id",
		]);

		$this->hasOne('Sections', [
			'foreignKey' => 'id',
			'bindingKey' => "section_id",
			'propertyName' => "section",
		]);

		$this->hasOne('Rows', [
			'foreignKey' => 'id',
			'bindingKey' => "row_id",
			'propertyName' => "row",
		]);
	}

}