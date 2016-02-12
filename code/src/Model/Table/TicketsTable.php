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

        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('show_name', 'create')
            ->notEmpty('show_name');

        $validator
            ->add('show_date', 'valid', ['rule' => 'date'])
            ->requirePresence('show_date', 'create')
            ->notEmpty('show_date');

        $validator
            ->add('start_time', 'valid', ['rule' => 'time'])
            ->requirePresence('start_time', 'create')
            ->notEmpty('start_time');

        $validator
            ->add('end_time', 'valid', ['rule' => 'time'])
            ->requirePresence('end_time', 'create')
            ->notEmpty('end_time');

        $validator
            ->requirePresence('theater', 'create')
            ->notEmpty('theater');

        $validator
            ->requirePresence('section', 'create')
            ->notEmpty('section');

        $validator
            ->requirePresence('row', 'create')
            ->notEmpty('row');

        $validator
            ->add('seat', 'valid', ['rule' => 'numeric'])
            ->requirePresence('seat', 'create')
            ->notEmpty('seat');

        $validator
            ->add('accessible_seat', 'valid', ['rule' => 'boolean'])
            ->requirePresence('accessible_seat', 'create')
            ->notEmpty('accessible_seat');

        $validator
            ->add('paid', 'valid', ['rule' => 'boolean'])
            ->requirePresence('paid', 'create')
            ->notEmpty('paid');

        $validator
            ->requirePresence('payment_method', 'create')
            ->notEmpty('payment_method');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['customer_id'], 'Customers'));
        return $rules;
    }
}
