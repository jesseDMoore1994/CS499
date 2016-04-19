<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\Error\Debugger;

class TicketAdminController extends AdminController {

	public function index() {
		$tickets = TableRegistry::get('Tickets');
		$pass = [];
		$query = null;
        $searchTerm = null;


        if(isset($this->request->query['search'])) {
            $searchTerm = $this->request->query['search'];
        }else{$searchTerm == '';}

		if ($this->adminTheater == 0) {
            if($searchTerm == '') {
                $query = $tickets->find()
                    ->contain(['Seats', 'Rows', 'Sections', 'Performances', 'Performances.Plays']);
            }else{
                $query = $tickets->find()
                    ->where(["Tickets.customer_name" => $searchTerm])
                    ->orWhere(["Tickets.id" => $searchTerm])
                    ->orWhere(["Plays.name" => $searchTerm])
                    ->contain(['Seats', 'Rows', 'Sections', 'Performances', 'Performances.Plays']);

            }
		} else {
            if($searchTerm == '') {
                $query = $tickets->find()
                    ->where(["Tickets.theater_id" => $this->adminTheater])
                    ->contain(['Seats', 'Rows', 'Sections', 'Performances', 'Performances.Plays', 'Seasons']);
            }else{
                $query = $tickets->find()
                    ->where(["Tickets.theater_id" => $this->adminTheater])
                    ->andWhere(["Tickets.customer_name" => $searchTerm])
                    ->orWhere(["Plays.name" => $searchTerm])
                    ->contain(['Seats', 'Rows', 'Sections', 'Performances', 'Performances.Plays', 'Seasons']);

            }
		}

		foreach ($query as $row) {
			$pass[] = [
				"id" => $row->id,
				"seat" => $row->getSeatName(),
				"number" => $row->ticket_number,
				"performance_name" => ($row->performance_id == 0) ? $row->season->name : $row->performance->play->name,
				"performance_time" => $row->ticketTime(),
				"person_name" => $row->customer_name,
				"payment_status" => $row->ticketStatusName(),
				"payment_status_value" => $row->status,
				"payment_state" => $row->ticketStatusColor()
			];
		}

		$this->set("seats", TableRegistry::get("Seats")
			->find()->where(["Seats.theater_id" => $this->adminTheater])->contain(["Rows", "Rows.Sections"])->all());
		$this->set("performances", TableRegistry::get("Performances")
			->find()->where(["Performances.theater_id" => $this->adminTheater])->contain(["Plays"])->all());
		$this->set("tickets", $pass);

	}
}