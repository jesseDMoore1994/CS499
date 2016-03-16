<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Ticket Entity.
 *
 * @property int $id
 * @property string $show_name
 * @property \Cake\I18n\Time $show_date
 * @property \Cake\I18n\Time $start_time
 * @property \Cake\I18n\Time $end_time
 * @property string $theater
 * @property string $section
 * @property string $row
 * @property int $seat
 * @property bool $accessible_seat
 * @property bool $paid
 * @property string $payment_method
 */
class Ticket extends Entity
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

    protected function _getId()
    {
        return $this->id;
    }

    protected function _getShowName()
    {
        return $this->show_name;
    }

    protected function _getShowDate()
    {
        return $this->show_date;
    }

    protected function _getStartTime()
    {
        return $this->start_time;
    }

    protected function _getEndTime()
    {
        return $this->end_time;
    }

    protected function _getTheater()
    {
        return $this->theater;
    }

    protected function _getSection()
    {
        return $this->section;
    }

    protected function _getRow()
    {
        return $this->row;
    }

    protected function _getSeat()
    {
        return $this->seat;
    }

    protected function _getAccessibleSeat()
    {
        return $this->accessible_seat;
    }

    protected function _getPaid()
    {
        return $this->paid;
    }

    protected function _getPaymentMethod()
    {
        return $this->payment_method;
    }

    protected function _setId($value)
    {
        return $value;
    }

    protected function _setShowName($value)
    {
        return $value;
    }

    protected function _setShowDate($value)
    {
        return $value;
    }

    protected function _setStartTime($value)
    {
        return $value;
    }

    protected function _setEndTime($value)
    {
        return $value;
    }

    protected function _setTheater($value)
    {
        return $value;
    }

    protected function _setSection($value)
    {
        return $value;
    }

    protected function _setRow($value)
    {
        return $value;
    }

    protected function _setSeat($value)
    {
        return $value;
    }

    protected function _setAccessibleSeat($value)
    {
        return $value;
    }

    protected function _setPaid($value)
    {
        return $value;
    }

    protected function _setPaymentMethod($value)
    {
        return $value;
    }
}
