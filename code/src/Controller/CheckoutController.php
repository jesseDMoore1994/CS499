<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class CheckoutController extends AppController
{
	public function index()
	{
		$this->viewBuilder()->layout("site");
		$this->set("css", ["site"]);

		// Get the table ready
		$table = TableRegistry::get("CartItems");

		$cart = $table
			->find()
			->where(["CartItems.cart_id" => $this->Cookie->read("ta_cart_id")])
			->contain([
				"Performances", "Performances.Plays",
				"Performances.Theaters",
				"Seats", "Seats.Rows", "Seats.Rows.Sections",
			])
			->all();

		if ($cart->count() < 1) {
			return $this->redirect("/cart/");
		}

		$pass = [];

		foreach ($cart as $item) {
			$pass[] = [
				$item->seat->price,
				$item->performance->play->name,
				$item->performance->theater->name,
				date("M d Y", $item->performance->start_time),
				date("h:i", $item->performance->start_time),
				$item->seat->orow->osection->code.
				$item->seat->orow->code.
				"-".
				$item->seat->code,
				$item->seat->id,
				$item->performance->id
			];
		}

		// Add up the cart total
		$pre_tax = 0;
		foreach ($pass as $item) { $pre_tax += $item[0]; }

		// Compute Tax
		$tax = $pre_tax * 0.09;

		// Pass the cart and total to the view
		$this->set("cart", $pass);
		$this->set("pre_tax", $pre_tax);
		$this->set("tax", $tax);
		$this->set("total", $pre_tax + $tax);
	}

	public function process()
	{

		$name = $this->request->data("card-name");

		// Get the table ready
		$table = TableRegistry::get("CartItems");
		$ticketTable = TableRegistry::get("Tickets");

		// Select the contents of the user's cart
		$cart = $table
			->find()
			->where(["CartItems.cart_id" => $this->Cookie->read("ta_cart_id")])
			->contain([
				"Performances", "Performances.Plays",
				"Performances.Theaters",
				"Seats", "Seats.Rows", "Seats.Rows.Sections",
			])
			->all();

		// Redirect if the cart is empty
		if ($cart->count() < 1) {
			return $this->redirect("/cart/");
		}

		$purchase_id = uniqid("", true).".".dechex(mt_rand(0,9999999999));

		$success = true;

		// For each item in the cart
		foreach ($cart as $item) {
			if ($item->season_ticket == 0) {

				// Check to see whether this ticket was already purchased
				$conflict = $ticketTable
					->find()
					->where([
						"seat_id" => $item->seat_id,
						"performance_id" => $item->performance_id,
					])
					->all();

				// If the ticket was already purchased
				if ($conflict->count() > 0) {

					// Delete the ticket from the cart
					$table->delete($item);

					// Display an error to the user
					$this->Flash->set("The seat ".$item->seat->orow->osection->code.$item->seat->orow->code."-".$item->seat->code." has already been taken.", [
						'element' => 'error'
					]);

					// Redirect back to the view cart page
					return $this->redirect("/cart/");

				}

				// Create the ticket
				$ticket = $ticketTable->newEntity([
					"theater_id" => $item->performance->theater->id,
					"section_id" => $item->seat->orow->osection->id,
					"row_id" => $item->seat->orow->id,
					"seat_id" => $item->seat->id,
					"status" => "paid",
					"customer_id" => (($item->loggedIn) ? $item->user->id : 0),
					"customer_name" => (($item->loggedIn) ? $item->user->name : $name),
					"ticket_number" => bin2hex($item->performance_id.":".$item->seat->id),
					"performance_id" => $item->performance_id,
					"season_ticket" => "0",
					"season_year" => date("Y"),
					"purchase_id" => $purchase_id
				]);

				// Save it to the database
				$success = $ticketTable->save($ticket) && $success;

				// Delete the purchase from the user's cart
				$table->delete($item);

			}
		}

		if ($success) {
			return $this->redirect("/checkout/success/$purchase_id/");
		} else {
			return $this->redirect("/checkout/");
		}


	}

	public function success($pid) {
		$this->viewBuilder()->layout("site");
		$this->set("css", ["site"]);

		$ticketTable = TableRegistry::get("Tickets");

		$purchase = $ticketTable
			->find()
			->where([
				"purchase_id" => $pid,
			])
			->contain(['Seats', 'Rows', 'Sections', 'Performances', 'Theaters', 'Performances.Plays'])
			->all();

		$this->set("pid", $pid);
		$this->set("tickets", $purchase);
	}

	public function printer($pid) {
		$this->viewBuilder()->layout("basic");
		$this->set("css", ["site"]);

		$ticketTable = TableRegistry::get("Tickets");

		$purchase = $ticketTable
			->find()
			->where([
				"purchase_id" => $pid,
			])
			->contain(['Seats', 'Rows', 'Sections', 'Performances', 'Theaters', 'Performances.Plays'])
			->all();

		$this->set("tickets", $purchase);
	}
}
