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
			'foreignKey' => 'theater',
			'joinType' => 'INNER'
		]);

		$this->hasOne('Sections', [
			'foreignKey' => 'section',
			'joinType' => 'INNER'
		]);

		$this->hasOne('Rows', [
			'foreignKey' => 'row',
			'joinType' => 'INNER'
		]);
	}

}