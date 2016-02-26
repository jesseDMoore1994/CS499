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

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        '*' => true,
        'user_id' => false,
    ];

    protected function _getUserId()
    {
        return $this->user_id;
    }

    protected function _getUser()
    {
        return $this->user;
    }

    protected function _getAccessLevel()
    {
        return $this->access_level;
    }

    protected function _setUserId($value)
    {
        return $value;
    }

    protected function _setUser($value)
    {
        return $value;
    }

    protected function _setAccessLevel($value)
    {
        return $value;
    }
}
