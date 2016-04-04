<?php

namespace App\Controller;

use Cake\Core\Configure;

class TicketAdminController extends AdminController {

	public function index() {
		$this->set("tickets", [
			[
				"id" => "1",
				"seat" => "Seat F12",
				"number" => "123456-F12",
				"performance_name" => "Macbeth",
				"performance_time" => "Today, 10:00 pm",
				"person_name" => "Jane Doe",
				"payment_status" => "Unpaid (Cash)",
				"payment_status_value" => "unpaid-cash",
				"payment_state" => "bad"
			],
			[
				"id" => "2",
				"seat" => "Seat F12",
				"number" => "123456-F12",
				"performance_name" => "Macbeth",
				"performance_time" => "Today, 10:00 pm",
				"person_name" => "Jane Doe",
				"payment_status" => "Unpaid (Cash)",
				"payment_status_value" => "unpaid-cash",
				"payment_state" => "bad"
			],
			[
				"id" => "3",
				"seat" => "Seat F12",
				"number" => "123456-F12",
				"performance_name" => "Macbeth",
				"performance_time" => "Today, 10:00 pm",
				"person_name" => "Jane Doe",
				"payment_status" => "Unpaid (Cash)",
				"payment_status_value" => "unpaid-cash",
				"payment_state" => "bad"
			],
		]);
	}
}