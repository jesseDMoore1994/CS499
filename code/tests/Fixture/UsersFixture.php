<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 *
 */
class UsersFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 12, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'last_name' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'first_name' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'middle_initial' => ['type' => 'string', 'length' => 1, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'street' => ['type' => 'string', 'length' => 64, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'city' => ['type' => 'string', 'length' => 32, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'state' => ['type' => 'string', 'length' => 32, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'zip' => ['type' => 'string', 'length' => 12, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'phone_no' => ['type' => 'string', 'length' => 10, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'email' => ['type' => 'string', 'length' => 64, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'password' => ['type' => 'string', 'length' => 32, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'is_super_admin' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'season_ticket' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'date_created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'date_modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
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
            'id' => 2,
            'last_name' => 'A',
            'first_name' => 'B',
            'middle_initial' => 'C',
            'street' => '2211 renau rd.',
            'city' => 'huntsville',
            'state' => 'AL',
            'zip' => '35801',
            'phone_no' => '2565553214',
            'email' => 'yolo@x.com',
            'password' => 'aaaaaaa',
            'is_super_admin' => 0,
            'season_ticket' => 0,
            'date_created' => '2016-02-24 00:12:00',
            'date_modified' => '2016-02-24 00:18:30'
        ],
        [
            'id' => 1,
            'last_name' => 'Admin',
            'first_name' => 'Admin',
            'middle_initial' => 'A',
            'street' => '9000 baudway cir.',
            'city' => 'Circuit',
            'state' => 'Motherboard',
            'zip' => '1337',
            'phone_no' => '1234567890',
            'email' => 'admin@ticketangel.com',
            'password' => '1337H4X0R~',
            'is_super_admin' => 1,
            'season_ticket' => 0,
            'date_created' => '1970-01-01 00:00:01',
            'date_modified' => '1970-01-01 00:00:01'
        ],

        [
            'id' => 3,
            'last_name' => 'Doe',
            'first_name' => 'John',
            'middle_initial' => 'A',
            'street' => '321 street way',
            'city' => 'Generic',
            'state' => 'Place',
            'zip' => '123456',
            'phone_no' => '5555555555',
            'email' => 'john.doe@yohoo.net',
            'password' => 'password',
            'is_super_admin' => 0,
            'season_ticket' => 1,
            'date_created' => '2016-02-25 00:12:00',
            'date_modified' => '2016-02-25 00:18:30'
        ]
    ];
}
