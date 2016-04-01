<?php

namespace App\Controller;

use Cake\Core\Configure;

class ScheduleAdminController extends AdminController {
	public function index() {
		$this->set("performances", [
			[
				"performance_id" => "1234",
				"performance_name" => "The Tragedy of Macbeth",
				"performance_time" => "Today, 2:00pm",
				"performance_state" => "good",
				"performance_status" => "Active",
				"performance_sales_state" => "good",
				"performance_sales" => "50",
				"performance_capacity" => "100",
			],
			[
				"performance_id" => "1234",
				"performance_name" => "The Tragedy of Macbeth",
				"performance_time" => "Today, 2:00pm",
				"performance_state" => "good",
				"performance_status" => "Active",
				"performance_sales_state" => "bad",
				"performance_sales" => "20",
				"performance_capacity" => "100",
			]
		]);
	}
}