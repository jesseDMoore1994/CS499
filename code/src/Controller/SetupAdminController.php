<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class SetupAdminController extends AdminController {
	public function index() {

	}

	public function seats() {
		$sections = [
			[
				"name" => "Main",
				"rows" => [
					["code" => "A", "seats" => ["A1", "A2", "A3", "A4", "A5", "A6", "A7", "A8", "A9", "A10", "A11", "A12", "A13", "A14", "A15", "A16", "A17", "A18", "A19", "A20", "A21", "A22", "A23"]],
					["code" => "B", "seats" => ["B1", "B2", "B3", "B4", "B6", "B7", "B8", "B9", "B10"]],
					["code" => "C", "seats" => ["C1", "C2", "C3", "C4", "C4", "C7", "C8", "C9", "C10"]],
				]
			],
			[
				"name" => "Balchony",
				"rows" => [
					["code" => "X", "seats" => ["X1", "X2", "X3", "X4", "X6", "X7", "X8", "X9", "X10"]],
					["code" => "Y", "seats" => ["Y1", "Y2", "Y3", "Y4", "Y6", "Y7", "Y8", "Y9", "Y10"]],
					["code" => "Z", "seats" => ["Z1", "Z2", "Z3", "Z4", "Z4", "Z7", "Z8", "Z9", "Z10"]],
				]
			],
		];

		$this->set("sections", $sections);
	}

	public function seasons() {
		$table = TableRegistry::get("Seasons");

		$seasons = $table
			->find()
			->where(["theater_id" => $this->adminTheater])
			->all();

		$this->set("seasons", $seasons);
	}

	public function apiSeasonManage($edit = 0) {
		$this->viewBuilder()->layout("ajax");
		$this->render(false);

		$name = $this->request->data("name");
		$start = $this->request->data("start");
		$end = $this->request->data("end");
		$theater = $this->adminTheater;
		$price = $this->request->data("price");

		$table = TableRegistry::get("Seasons");

		$season = null;

		if ($edit == 0) {
			$season = $table->newEntity([
				"name" => $name,
				"start_time" => strtotime($start),
				"end_time" => strtotime($end),
				"theater_id" => $theater,
				"ticket_price" => $price
			]);
		} else {
			$season = $table
				->find()
				->where(["id" => $edit])
				->all();

			if ($season->count() < 1) {
				echo json_encode([
					"status" => "400", // HTTP 400: Client Error
					"response" => "Could not save season"
				]);
				return;
			} else {
				$season = $season->first();
				$season->name = $name;
				$season->start_time = strtotime($start);
				$season->end_time = strtotime($end);
				$season->ticket_price = $price;
			}
		}

		if ($table->save($season)) {
			echo json_encode([
				"status" => "200", // HTTP 200: Okay
				"response" => "Season saved"
			]);
			return;
		} else {
			echo json_encode([
				"status" => "400", // HTTP 400: Client Error
				"response" => "Could not save season"
			]);
			return;
		}
	}

	public function availability() {
		$sections = [
			[
				"name" => "Main",
				"rows" => [
					["code" => "A", "seats" => ["A1", "A2", "A3", "A4", "A6", "A7", "A8", "A9", "A10", "A11", "A12", "A13", "A14", "A15", "A16", "A17", "A18", "A19", "A20", "A21", "A22", "A23"]],
					["code" => "B", "seats" => ["B1", "B2", "B3", "B4", "B6", "B7", "B8", "B9", "B10"]],
					["code" => "C", "seats" => ["C1", "C2", "C3", "C4", "C4", "C7", "C8", "C9", "C10"]],
				]
			],
			[
				"name" => "Balchony",
				"rows" => [
					["code" => "X", "seats" => ["X1", "X2", "X3", "X4", "X6", "X7", "X8", "X9", "X10"]],
					["code" => "Y", "seats" => ["Y1", "Y2", "Y3", "Y4", "Y6", "Y7", "Y8", "Y9", "Y10"]],
					["code" => "Z", "seats" => ["Z1", "Z2", "Z3", "Z4", "Z4", "Z7", "Z8", "Z9", "Z10"]],
				]
			],
		];

		$this->set("sections", $sections);
	}

	public function staff() {
		$staff = [
			[
				"id" => "1",
				"name" => "Matt Eskridge",
				"email" => "matt@matteskridge.com",
				"access" => "Administrator",
				"access_level" => "2"
			],
			[
				"id" => "2",
				"name" => "Jane Doe",
				"email" => "jdoe456@example.com",
				"access" => "Cashier",
				"access_level" => "1"
			]
		];

		$this->set("staff", $staff);
	}
}