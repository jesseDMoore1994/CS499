<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TicketsFixture
 *
 */
class TicketsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 12, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'customer_id' => ['type' => 'integer', 'length' => 12, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'show_name' => ['type' => 'string', 'length' => 32, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'show_date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'start_time' => ['type' => 'time', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'end_time' => ['type' => 'time', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'theater' => ['type' => 'string', 'length' => 32, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'section' => ['type' => 'string', 'length' => 16, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'row' => ['type' => 'string', 'length' => 1, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'seat' => ['type' => 'integer', 'length' => 32, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'accessible_seat' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'paid' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'payment_method' => ['type' => 'string', 'length' => 32, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'latin1_swedish_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'customer_id' => 1,
            'show_name' => 'Romeo & Juliet',
            'show_date' => '2016-02-23',
            'start_time' => '00:17:30',
            'end_time' => '00:20:00',
            'theater' => 'theater 1',
            'section' => 'Mezzanine',
            'row' => 'E',
            'seat' => 12,
            'accessible_seat' => 0,
            'paid' => 1,
            'payment_method' => 'Cash'
        ],
        [
            'id' => 2,
            'customer_id' => 2,
            'show_name' => 'Othello',
            'show_date' => '2016-02-24',
            'start_time' => '00:17:30',
            'end_time' => '00:20:00',
            'theater' => 'theater 2',
            'section' => 'box',
            'row' => 'E',
            'seat' => 7,
            'accessible_seat' => 0,
            'paid' => 0,
            'payment_method' => ''
        ],
        [
            'id' => 3,
            'customer_id' => 3,
            'show_name' => 'A Midsummer Night\'s Dream',
            'show_date' => '2016-02-25',
            'start_time' => '00:17:30',
            'end_time' => '00:20:00',
            'theater' => 'theater 3',
            'section' => 'Front',
            'row' => 'A',
            'seat' => 7,
            'accessible_seat' => 1,
            'paid' => 1,
            'payment_method' => 'Credit'
        ]
    ];
}
