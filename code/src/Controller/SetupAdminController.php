<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Error\Debugger;
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\Utility\Text;

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

	public function import()
	{
		$submissionFile = '';
		$table = '';
		$fields = '';
		$format = '';



		//get form data
		if($this->request->is('post')):
		{
			$submissionFile = $this->request->data['submissionFile'];
			$table = $this->request->data['table'];
			$fields = $this->request->data['fields'];
			$format = $this->request->data['format'];
		} endif;

		//process
		if($this->request->is('post')):
		{
			if($submissionFile == ''): {
				$this->set('file_status', 'No file submitted, try again.');
			}elseif($submissionFile): {

                //read in file data
                $file = new File($submissionFile['tmp_name']);
                $rawFileData = $file->read(true,'r');
                $lineArr = $array = preg_split("/\r\n|\n|\r/", $rawFileData);

                //parse file data line by line for appropriate table
				$this->set('file_status', 'File submitted.');
				if($table == 0): //table is tickets
				{
                    $ticketsTable = TableRegistry::get('Tickets');
                    forEach($lineArr as $line){
                        $dataFields = Text::tokenize($line);
                        $ticket = $ticketsTable->newEntity();
                        $ticket->id = $dataFields[0];
                        $ticket->theater_id = $dataFields[1];
                        $ticket->section_id = $dataFields[2];
                        $ticket->row_id = $dataFields[3];
                        $ticket->seat_id = $dataFields[4];
                        $ticket->status = $dataFields[5];
                        $ticket->customer_id = $dataFields[6];
                        $ticket->customer_name = $dataFields[7];
                        $ticket->ticket_number = $dataFields[8];
                        $ticket->performance_id = $dataFields[9];
                        $ticket->season_id = $dataFields[10];
                        $ticket->purchase_id = $dataFields[11];
                        $ticketsTable->save($ticket);
                    }

				}elseif($table == 1): //table is staff assignments
				{
                    $staffAssignmentsTable = TableRegistry::get('StaffAssignments');
                    forEach($lineArr as $line) {
                        $dataFields = Text::tokenize($line);
                        $staffAssignment = $staffAssignmentsTable->newEntity();
                        $staffAssignment->id = $dataFields[0];
                        $staffAssignment->user_id = $dataFields[1];
                        $staffAssignment->theater_id = $dataFields[2];
                        $staffAssignment->access_level = $dataFields[3];
                        $staffAssignmentsTable->save($staffAssignment);
                    }

				}elseif($table == 2): //table is users
				{
                    $usersTable = TableRegistry::get('Users');
                    forEach($lineArr as $line) {
                        $dataFields = Text::tokenize($line);
                        $user = $usersTable->newEntity();
                        $user->id = $dataFields[0];
                        $user->name = $dataFields[1];
                        $user->street = $dataFields[2];
                        $user->city = $dataFields[3];
                        $user->state = $dataFields[4];
                        $user->zip = $dataFields[5];
                        $user->phone_number = $dataFields[6];
                        $user->email = $dataFields[7];
                        $user->password = $dataFields[8];
                        $user->is_super_admin = $dataFields[9];
                        $user->date_created = $dataFields[10];
                        $user->date_modified = $dataFields[11];
                        $user->salt = $dataFields[12];
                        $usersTable->save($user);
                    }

				}elseif($table == 3): //table is theaters
                {
                    $theatersTable = TableRegistry::get('Theaters');
                    forEach($lineArr as $line) {
                        $dataFields = Text::tokenize($line);
                        $theater = $theatersTable->newEntity();
                        $theater->id = $dataFields[0];
                        $theater->name = $dataFields[1];
                        $theater->sales_tax = $dataFields[2];
                        $theater->description = $dataFields[3];
                        $theater->location = $dataFields[4];
                        $theater->artwork = $dataFields[5];
                        $theatersTable->save($theater);
                    }

                }elseif($table == 4): //table is sections
                {
                    $sectionsTable = TableRegistry::get('Sections');
                    forEach($lineArr as $line) {
                        $dataFields = Text::tokenize($line);
                        $section = $sectionsTable->newEntity();
                        $section->id = $dataFields[0];
                        $section->name = $dataFields[1];
                        $section->code = $dataFields[2];
                        $section->theater = $dataFields[3];
                        $section->accessible_section = $dataFields[4];
                        $section->front_text = $dataFields[5];
                        $section->back_text = $dataFields[6];
                        $sectionsTable->save($section);
                    }

                }elseif($table == 5): //table is seats
                {
                    $seatsTable = TableRegistry::get('Seats');
                    forEach($lineArr as $line) {
                        $dataFields = Text::tokenize($line);
                        $seat = $seatsTable->newEntity();
                        $seat->id = $dataFields[0];
                        $seat->theater = $dataFields[1];
                        $seat->section = $dataFields[2];
                        $seat->row = $dataFields[3];
                        $seat->code = $dataFields[4];
                        $seat->price = $dataFields[5];
                        $seatsTable->save($seat);
                    }

                }elseif($table == 6): //table is seasons
                {
                    $seasonsTable = TableRegistry::get('Seasons');
                    forEach($lineArr as $line) {
                        $dataFields = Text::tokenize($line);
                        $season = $seasonsTable->newEntity();
                        $season->id = $dataFields[0];
                        $season->name = $dataFields[1];
                        $season->start_time = $dataFields[2];
                        $season->end_time = $dataFields[3];
                        $season->ticket_price = $dataFields[4];
                        $season->theater_id = $dataFields[5];
                        $seasonsTable->save($season);
                    }

                }elseif($table == 7): //table is rows
                {
                    $rowsTable = TableRegistry::get('Rows');
                    forEach($lineArr as $line) {
                        $dataFields = Text::tokenize($line);
                        $row = $rowsTable->newEntity();
                        $row->id = $dataFields[0];
                        $row->theater = $dataFields[1];
                        $row->section = $dataFields[2];
                        $row->code = $dataFields[3];
                        $rowsTable->save($row);
                    }

                }elseif($table == 8): //table is plays
                {
                    $playsTable = TableRegistry::get('Plays');
                    forEach($lineArr as $line) {
                        $dataFields = Text::tokenize($line);
                        $play = $playsTable->newEntity();
                        $play->id = $dataFields[0];
                        $play->name = $dataFields[1];
                        $play->artwork = $dataFields[2];
                        $play->description = $dataFields[3];
                        $play->author = $dataFields[4];
                        $playsTable->save($play);
                    }

                }elseif($table == 9): //table is performances
                {
                    $performancesTable = TableRegistry::get('Performances');
                    forEach($lineArr as $line) {
                        $dataFields = Text::tokenize($line);
                        $performance = $performancesTable->newEntity();
                        $performance->id = $dataFields[0];
                        $performance->start_time = $dataFields[1];
                        $performance->open = $dataFields[2];
                        $performance->canceled = $dataFields[3];
                        $performance->play_id = $dataFields[4];
                        $performance->theater_id = $dataFields[5];
                        $performance->season_id = $dataFields[6];
                        $performancesTable->save($performance);
                    }

                }elseif($table == 10): //table is cart_items
                {
                    $cart_itemsTable = TableRegistry::get('Cart_items');
                    forEach($lineArr as $line) {
                        $dataFields = Text::tokenize($line);
                        $cart_items = $cart_itemsTable->newEntity();
                        $cart_items->id = $dataFields[0];
                        $cart_items->cart_id = $dataFields[1];
                        $cart_items->performance_id = $dataFields[2];
                        $cart_items->seat_id = $dataFields[3];
                        $cart_items->season_ticket = $dataFields[4];
                        $cart_itemsTable->save($cart_items);
                    }

                }else:
				{
					$this->Flash->error('Unexpected table value');
				}endif;
			}else: {
				$this->set('file_status', 'Please submit a file.');
			}endif;
		}
		else:
		{
			$this->set('file_status', 'Please submit a file.');
		} endif;

	}

	public function export()
	{
        $tableName = '';
        $table = '';
        $fields = '';
        $format = '';



        //get form data
        if($this->request->is('post')):
        {
            $table = $this->request->data['table'];
            $fields = $this->request->data['fields'];
            $format = $this->request->data['format'];
        } endif;

        //process
        if($this->request->is('post')):
        {
            $str = '';

            if($table == 0): //table is tickets
            {
                $tableName = 'tickets';
                $ticketsTable = TableRegistry::get('tickets');
                $query = $ticketsTable->find('all');
                $str = "id".","."theater_id".","."section_id".","."row_id".","."seat_id".","."status".","."customer_id".
                    ","."customer_name".","."ticket_number".","."performance_id".","."season_id".","."purchase_id\r\n";

                $results = $query->toArray();

                forEach($results as $item) {
                    $str .= $item->id . ",";
                    $str .= $item->theater_id . ",";
                    $str .= $item->section_id . ",";
                    $str .= $item->row_id . ",";
                    $str .= $item->seat_id . ",";
                    $str .= $item->status . ",";
                    $str .= $item->customer_id . ",";
                    $str .= "\"" . $item->customer_name . "\"" . ",";
                    $str .= $item->ticket_number . ",";
                    $str .= $item->performance_id . ",";
                    $str .= $item->season_id . ",";
                    $str .= $item->purchase_id;
                    $str .= "\r\n";
                }



            }elseif($table == 1): //table is staff assignments
            {
                $tableName = 'staffAssignments';
                $staffAssignmentsTable = TableRegistry::get('staffAssignments');
                $query = $staffAssignmentsTable->find('all');
                $str = "id".","."user_id".","."theater_id".","."access_level\r\n";

                $results = $query->toArray();

                forEach($results as $item) {
                    $str .= $item->id . ",";
                    $str .= $item->user_id . ",";
                    $str .= $item->theater_id . ",";
                    $str .= $item->access_level;
                    $str .= "\r\n";
                }

            }elseif($table == 2): //table is users
            {
                $tableName = 'users';
                $ticketsTable = TableRegistry::get('users');
                $query = $ticketsTable->find('all');
                $str = "id".","."name".","."street".","."city".","."state".","."zip".","."phone_number".
                    ","."email".","."password".","."is_super_admin".","."date_created".","."date_modified".","."salt\r\n";

                $results = $query->toArray();

                forEach($results as $item) {
                    $str .= $item->id . ",";
                    $str .= "\"" . $item->name . "\"" . ",";
                    $str .= "\"" . $item->street . "\"" . ",";
                    $str .= "\"" . $item->city . "\"" . ",";
                    $str .= "\"" . $item->state . "\"" . ",";
                    $str .= "\"" . $item->zip . "\"" . ",";
                    $str .= "\"" . $item->phone_number . "\"" . ",";
                    $str .= "\"" . $item->email . "\"" . ",";
                    $str .= "\"" . $item->password . "\"" . ",";
                    $str .= $item->is_super_admin . ",";
                    $str .= "\"" . $item->date_created . "\"" . ",";
                    $str .= "\"" . $item->date_modified . "\"" . ",";
                    $str .= "\"" . $item->salt . "\"";
                    $str .= "\r\n";
                }

            }elseif($table == 3): //table is theaters
            {
                $tableName = 'theaters';
                $theatersTable = TableRegistry::get('theaters');
                $query = $theatersTable->find('all');
                $str = "id".","."name".","."sales_tax".","."description".","."location".","."artwork\r\n";

                $results = $query->toArray();

                forEach($results as $item) {
                    $str .= $item->id . ",";
                    $str .= "\"" . $item->name . "\"" . ",";
                    $str .= $item->sales_tax . ",";
                    $str .= "\"" . $item->description . "\"" . ",";
                    $str .= "\"" . $item->location . "\"" . ",";
                    $str .= "\"" . $item->artwork . "\"";
                    $str .= "\r\n";
                }

            }elseif($table == 4): //table is sections
            {
                $tableName = 'sections';
                $sectionsTable = TableRegistry::get('sections');
                $query = $sectionsTable->find('all');
                $str = "id".","."name".","."code".","."theater".","."accessible_section".","."front_text".","."back_text\r\n";

                $results = $query->toArray();

                forEach($results as $item) {
                    $str .= $item->id . ",";
                    $str .= "\"" . $item->name . "\"" . ",";
                    $str .= "\"" . $item->code . "\"" . ",";
                    $str .= $item->theater . ",";
                    $str .= $item->accessible_section . ",";
                    $str .= "\"" . $item->front_text . "\"" . ",";
                    $str .= "\"" . $item->back_text . "\"";
                    $str .= "\r\n";
                }

            }elseif($table == 5): //table is seats
            {
                $tableName = 'seats';
                $seatsTable = TableRegistry::get('seats');
                $query = $seatsTable->find('all');
                $str = "id".","."theater".","."section".","."row".","."code".","."price\r\n";

                $results = $query->toArray();

                forEach($results as $item) {
                    $str .= $item->id . ",";
                    $str .= $item->theater . ",";
                    $str .= $item->section . ",";
                    $str .= $item->row . ",";
                    $str .= "\"" . $item->code . "\"" . ",";
                    $str .= $item->price;
                    $str .= "\r\n";
                }

            }elseif($table == 6): //table is seasons
            {
                $tableName = 'seasons';
                $seasonsTable = TableRegistry::get('seasons');
                $query = $seasonsTable->find('all');
                $str = "id".","."name".","."start_time".","."end_time".","."ticket_price".","."theater_id"."\r\n";

                $results = $query->toArray();

                forEach($results as $item) {
                    $str .= $item->id . ",";
                    $str .= "\"" . $item->name . "\"" . ",";
                    $str .= $item->start_time . ",";
                    $str .= $item->end_time . ",";
                    $str .= $item->ticket_price . ",";
                    $str .= $item->theater_id;
                    $str .= "\r\n";
                }

            }elseif($table == 7): //table is rows
            {
                $tableName = 'rows';
                $rowsTable = TableRegistry::get('rows');
                $query = $rowsTable->find('all');
                $str = "id".","."theater".","."section".","."code\r\n";

                $results = $query->toArray();

                forEach($results as $item) {
                    $str .= $item->id . ",";
                    $str .= $item->theater . ",";
                    $str .= $item->section . ",";
                    $str .= "\"" . $item->code . "\"";
                    $str .= "\r\n";
                }

            }elseif($table == 8): //table is plays
            {
                $tableName = 'plays';
                $playsTable = TableRegistry::get('plays');
                $query = $playsTable->find('all');
                $str = "id".","."name".","."artwork".","."description".","."author\r\n";

                $results = $query->toArray();

                forEach($results as $item) {
                    $str .= $item->id . ",";
                    $str .= "\"" . $item->name . "\"" . ",";
                    $str .= "\"" . $item->artwork . "\"" . ",";
                    $str .= "\"" . $item->description . "\"" . ",";
                    $str .= "\"" . $item->author . "\"";
                    $str .= "\r\n";
                }

            }elseif($table == 9): //table is performances
            {
                $tableName = 'performances';
                $ticketsTable = TableRegistry::get('performances');
                $query = $ticketsTable->find('all');
                $str = "id".","."start_time".","."open".","."canceled".","."play_id".","."theater_id".","."season_id\r\n";

                $results = $query->toArray();

                forEach($results as $item) {
                    $str .= $item->id . ",";
                    $str .= $item->start_time . ",";
                    $str .= $item->open . ",";
                    $str .= $item->canceled . ",";
                    $str .= $item->play_id . ",";
                    $str .= $item->theater_id . ",";
                    $str .= $item->season_id;
                    $str .= "\r\n";
                }

            }elseif($table == 10): //table is cart_items
            {
                $tableName = 'cart_items';
                $ticketsTable = TableRegistry::get('cart_items');
                $query = $ticketsTable->find('all');
                $str = "id".","."cart_id".","."performance_id".","."seat_id".","."season_ticket\r\n";

                $results = $query->toArray();

                forEach($results as $item) {
                    $str .= $item->id . ",";
                    $str .= "\"" . $item->cart_id . "\"" . ",";
                    $str .= "\"" . $item->performance_id . "\"" . ",";
                    $str .= $item->seat_id . ",";
                    $str .= $item->season_ticket;
                    $str .= "\r\n";
                }

            }else:
            {
                $this->Flash->error('Unexpected table value');
            }endif;

            $file = new File('tmp/',true);
            $file->open('w');
            $file->append($str);
            $this->response->file($file->path,['download' => true, 'name' => $tableName .'.csv']);
        }
        else:
        {
            $this->set('file_status', 'Please submit a file.');
        } endif;

    }
}