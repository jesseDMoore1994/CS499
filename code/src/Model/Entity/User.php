<?php
namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity.
 *
 * @property int $id
 * @property string $last_name
 * @property string $first_name
 * @property string $middle_initial
 * @property string $street
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $phone_no
 * @property string $email
 * @property string $password
 * @property bool $is_super_admin
 * @property bool $season_ticket
 * @property \Cake\I18n\Time $date_created
 * @property \Cake\I18n\Time $date_modified
 * @property \App\Model\Entity\StaffAssignment[] $staff_assignments
 */
class User extends Entity
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
        'id' => false,
    ];

    /**
     * Fields that are excluded from JSON an array versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    protected function _getId()
    {
        return $this->id;
    }

    protected function _getLastName()
    {
        return $this->last_name;
    }

    protected function _getFirstName()
    {
        return $this->first_name;
    }

    protected function _getMiddleInitial()
    {
        return $this->middle_initial;
    }

    protected function _getStreet()
    {
        return $this->street;
    }

    protected function _getCity()
    {
        return $this->city;
    }

    protected function _getState()
    {
        return $this->state;
    }

    protected function _getZip()
    {
        return $this->zip;
    }

    protected function _getPhoneNo()
    {
        return $this->phone_no;
    }

    protected function _getEmail()
    {
        return $this->email;
    }

    protected function _getPassword()
    {
        return $this->password;
    }

    protected function _getIsSuperAdmin()
    {
        return $this->is_super_admin;
    }

    protected function _getSeasonTicket()
    {
        return $this->season_ticket;
    }

    protected function _getDateCreated()
    {
        return $this->date_created;
    }

    protected function _getDateModified()
    {
        return $this->date_modified;
    }

    protected function _setId($value)
    {
        return $value;
    }

    protected function _setLastName($value)
    {
        return $value;
    }

    protected function _setFirstName($value)
    {
        return $value;
    }

    protected function _setMiddleInitial($value)
    {
        return $value;
    }

    protected function _setStreet($value)
    {
        return $value;
    }

    protected function _setCity($value)
    {
        return $value;
    }

    protected function _setState($value)
    {
        return $value;
    }

    protected function _setZip($value)
    {
        return $value;
    }

    protected function _setPhoneNo($value)
    {
        return $value;
    }

    protected function _setEmail($value)
    {
        return $value;
    }

    protected function _setPassword($value)
    {
        $hasher = new DefaultPasswordHasher();
        return $hasher->hash($value);
    }

    protected function _setIsSuperAdmin($value)
    {
        return $value;
    }

    protected function _setSeasonTicket($value)
    {
        return $value;
    }

    protected function _setDateCreated($value)
    {
        return $value;
    }

    protected function _setDateModified($value)
    {
        return $value;
    }
}
