<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class CustomerAdminController extends AdminController {
	public function index() {
		$users = TableRegistry::get('Users');
		$staff = TableRegistry::get('StaffAssignments');
		$pass = [];
		$query = $users->find();

		foreach ($query as $row) {

			$assignment = $staff->find("all")
				->where(['theater_id' => $this->adminTheater, 'user_id' => $row->id])
				->all();

			$staff_name = "Customer";
			$staff_level = "0";

			if ($assignment->count() > 0) {
				$staff_level = $assignment->first()->access_level;
				if ($staff_level == 1) {
					$staff_name = "Cashier";
				} else if ($staff_level == 2) {
					$staff_name = "Administrator";
				}
			}

			$pass[] = [
				"id" => $row->id,
				"name" => $row->name,
				"email" => $row->email,
				"access" => $staff_name,
				"joined" => $row->date_created,
				"state" => "good",
				"status" => "Active",
				"access_level" => $staff_level
			];
		}

		$this->set("customers", $pass);
	}
}