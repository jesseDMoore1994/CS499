<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * StaffAssignment Entity.
 *
 * @property int $user_id
 * @property \App\Model\Entity\User $user
 * @property int $theater_id
 * @property \App\Model\Entity\Theater $theater
 * @property int $access_level
 */
class StaffAssignment extends Entity
{

    protected $_accessible = [
        '*' => true,
    ];


}
