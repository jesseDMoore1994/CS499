<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class ScheduleAdminController extends AdminController {
	public function index() {

		$table = TableRegistry::get('Performances');
		$pass = [];
		$query = $table->find()
			->where(["theater_id" => $this->adminTheater])
			->contain(["Plays"]);

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
				"performance_open" => $row->open,
				"performance_canceled" => $row->canceled,
				"performance_season" => $row->season_id
			];
		}

		$this->set("seasons", TableRegistry::get("Seasons")
			->find()->where(["theater_id" => $this->adminTheater])->all());
		$this->set("plays", TableRegistry::get("Plays")
			->find()->all());
		$this->set("performances", $pass);
		$this->set("separatorEnabled", false);
	}

	public function apiManage($edit = 0) {
		$this->viewBuilder()->layout("ajax");
		$this->render(false);

		$play_id = $this->request->data("play");
		$date = $this->request->data("date");
		$time = $this->request->data("time");
		$theater = $this->adminTheater;
		$season = $this->request->data("season");
		$open = $this->request->data("open");
		$canceled = $this->request->data("canceled");

		if (!strstr($time, ":")) {
			echo json_encode([
				"status" => "400", // HTTP 400: Client Error
				"response" => "Could not save"
			]);
			return;
		}

		// Convert the user-entered time to a timestamp
		$bits = explode(" ", $time);
		$bits2 = explode(":", $bits[0]);
		$hour = $bits2[0];
		$minute = $bits2[1];
		$period = $bits[1];
		$timeConverted = date("H:i:s", strtotime("$hour:$minute $period"));;
		$start_time = strtotime($date . ", " . $timeConverted);

		$table = TableRegistry::get("Performances");

		$entity = null;

		if ($edit == 0) {
			$entity = $table->newEntity([
				"play_id" => $play_id,
				"start_time" => $start_time,
				"theater_id" => $theater,
				"open" => $open,
				"canceled" => $canceled,
				"season_id" => $season
			]);
		} else {
			$entity = $table
				->find()->where(["id" => $edit])->all();

			if ($entity->count() < 1) {
				echo json_encode([
					"status" => "400", // HTTP 400: Client Error
					"response" => "Could not save"
				]);
				return;
			} else {
				$entity = $entity->first();
				$entity->play_id = $play_id;
				$entity->start_time = $start_time;
				$entity->theater_id = $theater;
				$entity->season_id = $season;
				$entity->open = $open;
				$entity->canceled = $canceled;
			}
		}

		if ($table->save($entity)) {
			echo json_encode([
				"status" => "200", // HTTP 200: Okay
				"response" => "Saved"
			]);
			return;
		} else {
			echo json_encode([
				"status" => "400", // HTTP 400: Client Error
				"response" => "Could not save"
			]);
			return;
		}
	}
}