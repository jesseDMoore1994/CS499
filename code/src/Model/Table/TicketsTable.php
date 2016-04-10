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
class TicketsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('tickets');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'id',
            'bindingKey' => 'customer_id',
        ]);

        $this->hasOne('Theaters', [
            'foreignKey' => 'id',
            'bindingKey' => 'theater_id'
        ]);

        $this->hasOne('Sections', [
            'foreignKey' => 'id',
            'bindingKey' => "section_id"
        ]);

        $this->hasOne('Rows', [
            'foreignKey' => 'id',
            'bindingKey' => "row_id"
        ]);

        $this->hasOne('Seats', [
            'foreignKey' => 'id',
            'bindingKey' => "seat_id"
        ]);

        $this->hasOne('Performances', [
            'foreignKey' => 'id',
            'bindingKey' => "performance_id"
        ]);

        $options = array(
            // Refer to php.net fgetcsv for more information
            'length' => 0,
            'delimiter' => ',',
            'enclosure' => '"',
            'escape' => '\\',
            // Generates a Model.field headings row from the csv file
            'headers' => true,
            // If true, String $content is the data, not a path to the file
            'text' => false,
        );
        //$this->addBehavior('CakePHPCSV.Csv', $options);
    }

    /*
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['customer_id'], 'Customers'));
        return $rules;
    }

    public function findId(Query $query, array $options)
    {
        return $this->find()
            ->distinct(['Tickets.id'])
            ->matching('Ids', function($q) use ($options){
                return $q->where(['Ids.id IN' => $options['ids']]);
            });
    }*/
}
