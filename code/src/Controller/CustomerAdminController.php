<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class CustomerAdminController extends AdminController {
	public function index() {
		$users = TableRegistry::get('Users');
		$pass = [];
		$query = $users->find();

		foreach ($query as $row) {
			$pass[] = [
				"id" => $row->id,
				"name" => $row->name,
				"email" => $row->email,
				"access" => "Customer",
				"joined" => "Today, 10:00am",
				"state" => "good",
				"status" => "Active",
				"access_level" => "2"
			];
		}

		$this->set("customers", $pass);
	}
}