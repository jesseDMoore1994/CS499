<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\I18n\Time;
use Cake\Error\Debugger;

class CustomerAdminController extends AdminController {
	public function index() {
		$users = TableRegistry::get('Users');
		$staff = TableRegistry::get('StaffAssignments');
		$pass = [];
        $searchTerm = null;

        if(isset($this->request->query['search'])) {
            $searchTerm = $this->request->query['search'];
        }else{$searchTerm = '';}

        if($searchTerm == '') {
            $query = $users->find();
        }else {
            $query = $users->find()
                ->where(['name' => $searchTerm])
                ->orWhere(['email' => $searchTerm])
                ->orWhere(['id' => $searchTerm]);
        }

        Debugger::dump($query->toArray());

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

	public function apiManage($edit = 0) {
		$this->viewBuilder()->layout("ajax");
		$this->render(false);

		$name = $this->request->data("name");
		$email = $this->request->data("email");
		$access_level = $this->request->data("access_level");
		$password = $this->request->data("password");
		$password_confirm = $this->request->data("password_confirm");
		$salt = uniqid(mt_rand(), true);

		/*$name = "Test2";
		$email = "test3@test.com";
		$access_level = 2;
		$password = "123";
		$password_confirm = "123";*/

		$table = TableRegistry::get("Users");

		if ($password != $password_confirm) {
			echo json_encode([
				"status" => "400", // HTTP 400: Client Error
				"response" => "Could not save 3"
			]);
			return;
		}

		$entity = null;

		if ($edit == 0) {
			$entity = $table->newEntity([
				"name" => $name,
				"email" => $email,
				"password" => pbkdf2("sha256", $password, $salt),
				"salt" => $salt,
				'date_created' => Time::createFromTimestamp(time())
			]);
		} else {
			$entity = $table
				->find()->where(["id" => $edit])->all();

			if ($entity->count() == 0) {
				echo json_encode([
					"status" => "400", // HTTP 400: Client Error
					"response" => "Could not save 1"
				]);
				return;
			} else {
				$entity = $entity->first();
				$entity->name = $name;
				$entity->email = $email;

				if ($password != "") {
					$entity->password = pbkdf2("sha256", $password, $salt);
					$entity->salt = $salt;
				}
			}
		}

		if ($table->save($entity)) {
			if ($edit == 0) {
				if ($access_level > 0) {
					$assignment = TableRegistry::get("StaffAssignments")
						->newEntity([
							"user_id" => $entity->id,
							"theater_id" => $this->adminTheater,
							"access_level" => $access_level
						]);
					TableRegistry::get("StaffAssignments")->save($assignment);
				}
			} else {
				$assignment = TableRegistry::get("StaffAssignments")
					->find()->where(["user_id" => $entity->id])->all();

				if ($assignment->count() > 0) {
					$assignment = $assignment->first();
					$assignment->access_level = $access_level;
					TableRegistry::get("StaffAssignments")->save($assignment);
				} else {
					$assignment = TableRegistry::get("StaffAssignments")
						->newEntity([
							"user_id" => $entity->id,
							"theater_id" => $this->adminTheater,
							"access_level" => $access_level
						]);
					TableRegistry::get("StaffAssignments")->save($assignment);
				}
			}


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