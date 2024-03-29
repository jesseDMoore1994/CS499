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
    ];

    /**
     * Fields that are excluded from JSON an array versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];

    public function isValid() {
        return
            strlen($this->name) > 3 &&
            strlen($this->email) > 3;
    }

	public function makeKey() {
		return sha1($this->id.$this->email.$this->salt.$this->password);
	}
}
