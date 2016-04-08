<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class TicketAdminController extends AdminController {

	public function index() {
		$tickets = TableRegistry::get('Tickets');
		$pass = [];
		$query = null;

		if ($this->adminTheater == 0) {
			$query = $tickets->find()
				->contain(['Seats', 'Rows', 'Sections', 'Performances', 'Performances.Plays']);
		} else {
			$query = $tickets->find()
				->where(["Tickets.theater_id" => $this->adminTheater])
				->contain(['Seats', 'Rows', 'Sections', 'Performances', 'Performances.Plays']);
		}

		foreach ($query as $row) {
			$pass[] = [
					"id" => $row->id,
					"seat" => $row->getSeatName(),
					"number" => "123456-F12",
					"performance_name" => $row->performance->play->name,
					"performance_time" => $row->ticketTime(),
					"person_name" => $row->customer_name,
					"payment_status" => $row->ticketStatusName(),
					"payment_status_value" => $row->status,
					"payment_state" => $row->ticketStatusColor()
				];
		}

		$this->set("tickets", $pass);

	}
}