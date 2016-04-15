<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Datasource\ConnectionManager;

class SetupAdminController extends AdminController {
	public function index() {
		if ($this->adminTheater != 0) {
			$this->set("theater", TableRegistry::get("Theaters")
				->find()->where(["id" => $this->adminTheater])->all()->first());
		}
	}

	public function seats() {
		$sectionTable = TableRegistry::get("Sections");
		$sections = $sectionTable
			->find()->where(["theater_id" => $this->adminTheater])
			->contain(["Rows", "Rows.Seats"])->all();
		$data = [];

		foreach ($sections as $section) {
			$rows = [];

			foreach ($section->rows as $row) {
				$rows[] = [
					"code" => $row->code,
					"seats" => $row->seats,
					"id" => $row->id
				];
			}

			$data = [
				"name" => $section->name,
				"rows" => $rows,
				"id" => $section->id
			];
		}

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

	public function apiCreateSection() {

		$this->viewBuilder()->layout("ajax");
		$this->render(false);

		$name = $this->request->data("name");
		$rows = (int) $this->request->data("rows");
		$seats = (int) $this->request->data("seats");
		$code = $this->request->data("code");
		$price = $this->request->data("price");

		$sectionTable = TableRegistry::get("Sections");
		$rowTable = TableRegistry::get("Rows");
		$seatTable = TableRegistry::get("Seats");

		$section = $sectionTable->newEntity([
			"name" => $name,
			"theater_id" => $this->adminTheater,
			"code" => $code,
			"front_text" => "Front",
			"back_text" => "Back"
		]);
		$sectionTable->save($section);

		$letter = 'A';
		if ($rows < 100) for ($i = 0; $i < $rows; $i++) {
			$r = $rowTable->newEntity([
				"code" => $letter,
				"section_id" => $section->id,
				"theater_id" => $this->adminTheater
			]);
			$rowTable->save($r);

			if ($seats < 100) for ($j = 0; $j < $seats; $j++) {
				//echo "Iterating seat $j<br />";
				$s = $seatTable->newEntity([
					"code" => $j+1,
					"section_id" => $section->id,
					"row_id" => $r->id,
					"theater_id" => $this->adminTheater,
					"price" => $price
				]);
				$seatTable->save($s);
			}

			$letter++;
		}

		echo json_encode([
			"status" => "200", // HTTP 200: Okay
			"response" => "Saved"
		]);
		return;
	}

	public function apiCreateRow() {

		$this->viewBuilder()->layout("ajax");
		$this->render(false);

		$section = $this->request->data("section");
		$seats = (int) $this->request->data("seats");
		$code = $this->request->data("code");
		$price = $this->request->data("price");

		$rowTable = TableRegistry::get("Rows");
		$seatTable = TableRegistry::get("Seats");

		$r = $rowTable->newEntity([
			"code" => $code,
			"section_id" => $section,
			"theater_id" => $this->adminTheater
		]);
		$rowTable->save($r);

		if ($seats < 100) for ($j = 0; $j < $seats; $j++) {
			//echo "Iterating seat $j<br />";
			$s = $seatTable->newEntity([
				"code" => $j+1,
				"section_id" => $section,
				"row_id" => $r->id,
				"theater_id" => $this->adminTheater,
				"price" => $price
			]);
			$seatTable->save($s);
		}

		echo json_encode([
			"status" => "200", // HTTP 200: Okay
			"response" => "Saved"
		]);
		return;
	}

	public function apiCreateSeat() {

		$this->viewBuilder()->layout("ajax");
		$this->render(false);

		$section = $this->request->data("section");
		$row = $this->request->data("row");
		$code = $this->request->data("code");
		$price = $this->request->data("price");

		$seatTable = TableRegistry::get("Seats");

		$s = $seatTable->newEntity([
			"code" => $code,
			"section_id" => $section,
			"row_id" => $row,
			"theater_id" => $this->adminTheater,
			"price" => $price
		]);
		$seatTable->save($s);

		echo json_encode([
			"status" => "200", // HTTP 200: Okay
			"response" => "Saved"
		]);
		return;
	}

	public function apiEditSection() {
		$this->viewBuilder()->layout("ajax");
		$this->render(false);

		$section = $this->request->data("section");
		$name = $this->request->data("name");
		$code = $this->request->data("code");

		$r = TableRegistry::get("Sections")
			->find()
			->where([
				"theater_id" => $this->adminTheater,
				"id" => $section
			])->all()->first();
		$r->name = $name;
		$r->code = $code;
		TableRegistry::get("Sections")->save($r);

		echo json_encode([
			"status" => "200", // HTTP 200: Okay
			"response" => "Saved"
		]);
		return;
	}

	public function apiEditRow() {
		$this->viewBuilder()->layout("ajax");
		$this->render(false);

		$row = $this->request->data("row");
		$code = $this->request->data("code");

		$r = TableRegistry::get("Rows")
			->find()
			->where([
				"theater_id" => $this->adminTheater,
				"id" => $row
			])->all()->first();
		$r->code = $code;
		TableRegistry::get("Rows")->save($r);

		echo json_encode([
			"status" => "200", // HTTP 200: Okay
			"response" => "Saved"
		]);
		return;
	}

	public function apiEditSeat() {
		$this->viewBuilder()->layout("ajax");
		$this->render(false);

		$seat = $this->request->data("seat");
		$code = $this->request->data("code");
		$price = $this->request->data("price");

		$s = TableRegistry::get("Seats")
			->find()
			->where([
				"theater_id" => $this->adminTheater,
				"id" => $seat
			])->all()->first();
		$s->code = $code;
		$s->price = $price;
		TableRegistry::get("Seats")->save($s);

		echo json_encode([
			"status" => "200", // HTTP 200: Okay
			"response" => "Saved"
		]);
		return;
	}

	public function apiDeleteSection() {
		$this->viewBuilder()->layout("ajax");
		$this->render(false);

		$section = $this->request->data("section");

		$r = TableRegistry::get("Sections")
			->find()
			->where([
				"theater_id" => $this->adminTheater,
				"id" => $section
			])->all()->first();
		TableRegistry::get("Sections")->delete($r);

		$connection = ConnectionManager::get('default');
		$connection->delete("tickets", ["section_id" => $section]);
		$connection->delete("rows", ["section_id" => $section]);
		$connection->delete("seats", ["section_id" => $section]);

		echo json_encode([
			"status" => "200", // HTTP 200: Okay
			"response" => "Saved"
		]);
		return;
	}

	public function apiDeleteSeat() {
		$this->viewBuilder()->layout("ajax");
		$this->render(false);

		$seat = $this->request->data("seat");

		$s = TableRegistry::get("Seats")
			->find()
			->where([
				"theater_id" => $this->adminTheater,
				"id" => $seat
			])->all()->first();
		TableRegistry::get("Seats")->delete($s);

		$connection = ConnectionManager::get('default');
		$connection->delete("tickets", ["seat_id" => $seat]);

		echo json_encode([
			"status" => "200", // HTTP 200: Okay
			"response" => "Saved"
		]);
		return;
	}

	public function apiDeleteRow() {
		$this->viewBuilder()->layout("ajax");
		$this->render(false);

		$row = $this->request->data("row");

		$r = TableRegistry::get("Rows")
			->find()
			->where([
				"theater_id" => $this->adminTheater,
				"id" => $row
			])->all()->first();
		TableRegistry::get("Rows")->delete($r);

		$connection = ConnectionManager::get('default');
		$connection->delete("tickets", ["row_id" => $row]);
		$connection->delete("seats", ["row_id" => $row]);

		echo json_encode([
			"status" => "200", // HTTP 200: Okay
			"response" => "Saved"
		]);
		return;
	}
}