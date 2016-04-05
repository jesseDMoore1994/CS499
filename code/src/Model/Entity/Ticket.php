<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

require_once(ROOT . DS . 'vendor' . DS  . 'theater-ticket' . DS . 'time_elapsed_string.php');

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
    ];

    public function getSeatName() {
        return "Seat ".$this->section->code.$this->row->code."-".$this->seat->code;
    }

    function ticketStatusColor() {
        switch ($this->status) {
            case "paid":
                return "good";
            case "paid-cash":
                return "good";
            case "unpaid":
                return "bad";
            case "unpaid-cash":
                return "bad";
            default:
                return "bad";
        }
    }

    function ticketStatusName() {
        switch ($this->status) {
            case "paid":
                return "Paid";
            case "paid-cash":
                return "Paid (Cash)";
            case "unpaid":
                return "Unpaid";
            case "unpaid-cash":
                return "Unpaid (Cash)";
            default:
                return "bad";
        }
    }

    function ticketTime() {
        return time_format($this->performance->time);
    }

}
