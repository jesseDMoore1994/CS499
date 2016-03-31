<?php

namespace App\Controller;

use Cake\Core\Configure;

class CustomerAdminController extends AdminController {
	public function index() {
		$this->set("customers", [
			[
				"customer_id" => "1234",
				"customer_first" => "Jane",
				"customer_last" => "Doe",
				"customer_state" => "good",
				"customer_status" => "Active",
				"customer_email" => "jdoe456@example.com",
			],
			[
				"customer_id" => "1234",
				"customer_first" => "Jane",
				"customer_last" => "Doe",
				"customer_state" => "good",
				"customer_status" => "Active",
				"customer_email" => "jdoe456@example.com"
			],
			[
				"customer_id" => "1234",
				"customer_first" => "Jane",
				"customer_last" => "Doe",
				"customer_state" => "good",
				"customer_status" => "Active",
				"customer_email" => "jdoe456@example.com"
			],
		]);
	}
}