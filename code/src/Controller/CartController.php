<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

class CartController extends AppController
{
	public function initialize()
	{
		parent::initialize();
		$this->loadComponent('RequestHandler');
	}

	public function index()
	{
		$this->viewBuilder()->layout("site");
		$this->set("css", ["site"]);

		// Load the cart contents
		$cart = [
			[15, "The Tragedy of Othello, the Moor", "Civil Center Playhouse", "January 1st, 2016", "10:00 PM", "F12"],
			[15, "The Tragedy of Othello, the Moor", "Civil Center Playhouse", "January 1st, 2016", "10:00 PM", "F13"],
		];

		// Add up the cart total
		$pre_tax = 0;
		foreach ($cart as $item) { $pre_tax += $item[0]; }

		// Compute Tax
		$tax = $pre_tax * 0.09;

		// Pass the cart and total to the view
		$this->set("cart", $cart);
		$this->set("pre_tax", $pre_tax);
		$this->set("tax", $tax);
		$this->set("total", $pre_tax + $tax);
	}

	function apiAdd($seat, $performance) {

		// Set up the view for an AJAX response
		$this->viewBuilder()->layout("ajax");
		$this->render(false);

		// Prepare the database for operations
		$table = TableRegistry::get("CartItems");
		$ticketTable = TableRegistry::get("Tickets");

		//
		// Conflict-Check
		// Prevent the user from adding a seat that
		// has already been purchased
		//

		// Select any conflicting tickets from the DB
		$conflicts = $ticketTable
			->find()
			->where([
				"seat_id" => $seat,
				"performance_id" => $performance])
			->all();

		// If there's a conflict, display an error
		if ($conflicts->count() > 0) {
			echo json_encode([
				"status" => "410", // HTTP 410: Gone
				"response" => "Seat is already taken"
			]);
			return;
		}

		//
		// Match-Check
		// Prevent the user from adding a seat to their
		// cart more than once
		//

		// Make sure the seat isn't already in the cart
		$matches = $table
			->find()
			->where([
				"seat_id" => $seat,
				"performance_id" => $performance,
				"cart_id" => $this->Cookie->read("ta_cart_id")
			])
			->all();

		// Display an error if the seat is already in the user's cart
		if ($matches->count() > 0) {
			echo json_encode([
				"status" => "409", // HTTP 409: Conflict
				"response" => "Seat is already in cart"
			]);
			return;
		}

		//
		// Insert Operation
		// Add the item to the user's cart in the database
		//

		// Get the cart item ready for database insert
		$item = $table->newEntity([
			"seat_id" => $seat,
			"performance_id" => $performance,
			"cart_id" => $this->Cookie->read("ta_cart_id")
		]);

		// Save the cart item
		if ($table->save($item)) {
			echo json_encode([
				"status" => "200", // HTTP 200: Success
				"response" => "Added to cart!"
			]);
			return;
		} else {
			echo json_encode([
				"status" => "500", // HTTP 500: Internal server error
				"response" => "Could not add to cart"
			]);
			return;
		}
	}

	function apiRemove($seat, $performance) {

		// Set up the view for an AJAX response
		$this->viewBuilder()->layout("ajax");
		$this->render(false);

		// Prepare the database for operations
		$table = TableRegistry::get("CartItems");

		//
		// Match-Check
		// Make sure that the seat is in the cart
		//

		// Make sure the seat is actually in the user's cart
		$matches = $table
			->find()
			->where([
				"seat_id" => $seat,
				"performance_id" => $performance,
				"cart_id" => $this->Cookie->read("ta_cart_id")
			])
			->all();

		// Display an error if the seat was not in the user's cart
		if ($matches->count() < 1) {
			echo json_encode([
				"status" => "410", // HTTP 409: Gone
				"response" => "Seat was not in cart."
			]);
			return;
		}

		// If the entity does exist, delete all matches
		foreach ($matches as $match) {
			$table->delete($match);
		}

		echo json_encode([
			"status" => "200", // HTTP 409: Gone
			"response" => "Ticket removed from cart."
		]);
		return;

	}
}
