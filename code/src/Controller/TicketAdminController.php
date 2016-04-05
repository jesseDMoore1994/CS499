<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class TicketAdminController extends AdminController {

	public function index() {
		$tickets = TableRegistry::get('Tickets');
		$pass = [];
		$query = $tickets->find()->contain(['Seats', 'Rows', 'Sections', 'Performances', 'Performances.Plays']);

		foreach ($query as $row) {
			$pass[] = [
					"id" => $row->id,
					"seat" => $row->getSeatName(),
					"number" => "123456-F12",
					"performance_name" => $row->performance->play->name,
					"performance_time" => "Today, 10:00 pm",
					"person_name" => $row->customer_name,
					"payment_status" => "Unpaid (Cash)",
					"payment_status_value" => $row->status,
					"payment_state" => ticketStatusColor($row->customer_name)
				];
		}

		$this->set("tickets", $pass);

	}
}

function ticketStatusColor($status) {
	switch ($status) {
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