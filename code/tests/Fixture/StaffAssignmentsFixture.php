<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * StaffAssignmentsFixture
 *
 */
class StaffAssignmentsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'user_id' => ['type' => 'integer', 'length' => 12, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'theater_id' => ['type' => 'integer', 'length' => 12, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'access_level' => ['type' => 'integer', 'length' => 8, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['user_id'], 'length' => []],
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
            'user_id' => 1,
            'theater_id' => 1,
            'access_level' => 1
        ],
        [
            'user_id' => 2,
            'theater_id' => 2,
            'access_level' => 2
        ],
        [
            'user_id' => 3,
            'theater_id' => 3,
            'access_level' => 3
        ],
        [
            'user_id' => 4,
            'theater_id' => 4,
            'access_level' => 4
        ],
        [
            'user_id' => 5,
            'theater_id' => 5,
            'access_level' => 5
        ],
        [
            'user_id' => 6,
            'theater_id' => 6,
            'access_level' => 6
        ],
        [
            'user_id' => 7,
            'theater_id' => 7,
            'access_level' => 7
        ]
    ];
}
