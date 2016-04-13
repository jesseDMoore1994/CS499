<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class TicketAdminController extends AdminController {

	public function index() {
		$tickets = TableRegistry::get('Tickets');
		$seatTable = TableRegistry::get('Seats');
		$pass = [];
		$query = null;

		if ($this->adminTheater == 0) {
			$query = $tickets->find()
				->contain(['Seats', 'Rows', 'Sections', 'Performances', 'Performances.Plays']);
		} else {
			$query = $tickets->find()
				->where(["Tickets.theater_id" => $this->adminTheater])
				->contain(['Seats', 'Rows', 'Sections', 'Performances', 'Performances.Plays', 'Seasons']);
		}

		foreach ($query as $row) {
			$pass[] = [
				"id" => $row->id,
				"seat" => $row->getSeatName(),
				"number" => $row->ticket_number,
				"performance_name" => ($row->performance_id == 0) ? $row->season->name : $row->performance->play->name,
				"performance_time" => $row->ticketTime(),
				"person_name" => $row->customer_name,
				"payment_status" => $row->ticketStatusName(),
				"payment_status_value" => $row->status,
				"payment_state" => $row->ticketStatusColor()
			];
		}

		$this->set("seats", TableRegistry::get("Seats")
			->find()->where(["Seats.theater" => $this->adminTheater])->contain(["Rows", "Rows.Sections"])->all());
		$this->set("performances", TableRegistry::get("Performances")
			->find()->where(["Performances.theater_id" => $this->adminTheater])->contain(["Plays"])->all());
		$this->set("tickets", $pass);

	}
}