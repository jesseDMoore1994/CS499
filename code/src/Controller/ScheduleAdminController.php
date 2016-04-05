<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class ScheduleAdminController extends AdminController {
	public function index() {

		$users = TableRegistry::get('Performances');
		$pass = [];
		$query = $users->find()->contain(["Plays"]);

		foreach ($query as $row) {
			$pass[] = [
				"performance_id" => $row->id,
				"performance_name" => $row->play->name,
				"performance_date" => $row->timeDate(),
				"performance_time" => $row->timeFormatted(),
				"performance_hour" => $row->timeHour(),
				"performance_state" => "good",
				"performance_status" => "Active",
				"performance_sales_state" => "good",
				"performance_sales" => "50",
				"performance_capacity" => "100",
				"performance_open" => "1",
				"performance_canceled" => "0",
			];
		}

		$this->set("performances", $pass);
		$this->set("separatorEnabled", false);
	}
}