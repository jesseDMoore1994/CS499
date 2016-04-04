<?php

namespace App\Controller;

use Cake\Core\Configure;

class CustomerAdminController extends AdminController {
	public function index() {
		$this->set("customers", [
			[
				"id" => "1",
				"name" => "Matt Eskridge",
				"email" => "matt@matteskridge.com",
				"access" => "Administrator",
				"joined" => "Today, 10:00am",
				"state" => "good",
				"status" => "Active",
				"access_level" => "2"
			],
			[
				"id" => "2",
				"name" => "Jane Doe",
				"email" => "jdoe456@gmail.com",
				"access" => "Cashier",
				"joined" => "Today, 10:00am",
				"state" => "good",
				"status" => "Active",
				"access_level" => "1"
			],
		]);
	}
}