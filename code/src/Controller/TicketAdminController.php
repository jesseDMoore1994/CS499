<?php

namespace App\Controller;

use Cake\Core\Configure;

class TicketAdminController extends AdminController {
	public function index() {
		$this->set("tickets", [
			[
				"seat" => "Seat F12",
				"id" => "123456-F12",
				"performance_name" => "Macbeth",
				"performance_time" => "Today, 10:00 pm",
				"person_name" => "Jane Doe",
				"payment_status" => "Unpaid (Cash)",
				"payment_state" => "bad"
			],
			[
				"seat" => "Seat F12",
				"id" => "123456-F12",
				"performance_name" => "Macbeth",
				"performance_time" => "Today, 10:00 pm",
				"person_name" => "Jane Doe",
				"payment_status" => "Unpaid (Cash)",
				"payment_state" => "bad"
			],
			[
				"seat" => "Seat F12",
				"id" => "123456-F12",
				"performance_name" => "Macbeth",
				"performance_time" => "Today, 10:00 pm",
				"person_name" => "Jane Doe",
				"payment_status" => "Unpaid (Cash)",
				"payment_state" => "bad"
			],
		]);
	}
}