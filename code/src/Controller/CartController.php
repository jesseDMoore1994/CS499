<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
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

		// Get the table ready
		$table = TableRegistry::get("CartItems");

		$cart = $table
			->find()
			->where(["CartItems.cart_id" => $this->Cookie->read("ta_cart_id")])
			->contain([
				"Performances", "Performances.Plays",
				"Performances.Theaters",
				"Seats", "Seats.Rows", "Seats.Rows.Sections",
				"Seasons", "Seasons.Theaters"
			])
			->all();

		$pass = [];

		foreach ($cart as $item) {
			$pass[] = [
				($item->performance == null) ? $item->season->ticket_price : $item->seat->price,
				($item->performance == null) ? $item->season->name : $item->performance->play->name,
				($item->performance == null) ? $item->season->theater->name : $item->performance->theater->name,
				($item->performance == null) ? date("M d Y", $item->season->start_time) : date("M d Y", $item->performance->start_time),
				($item->performance == null) ? date("h:i", $item->season->start_time) : date("h:i", $item->performance->start_time),
				$item->seat->orow->osection->code.
					$item->seat->orow->code.
					"-".
					$item->seat->code,
				$item->seat->id,
				($item->performance == null) ? $item->season->id : $item->performance->id,
				$item->id
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

		$seats = TableRegistry::get("Seats")
			->find()
			->where(["id" => $seat])
			->all();

		// Display an error if the seat doesn't exist
		if ($seats->count() == 0) {
			echo json_encode([
				"status" => "404", // HTTP 404: Not Found
				"response" => "Seat is already taken"
			]);
			return;
		}

		// Make sure the seat is available
		if (!$seats->first()->isAvailablePerformance(TableRegistry::get("Performances")
			->find()->where(["Performances.id" => $performance])->contain(["Seasons"])->all()->first())) {
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

	function apiAddseason($seat, $season_id) {

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

		$seats = TableRegistry::get("Seats")
			->find()
			->where(["id" => $seat])
			->all();

		// Display an error if the seat doesn't exist
		if ($seats->count() == 0) {
			echo json_encode([
				"status" => "404", // HTTP 404: Not Found
				"response" => "Seat is already taken"
			]);
			return;
		}

		// Make sure the seat is available
		if (!$seats->first()->isAvailableSeason(TableRegistry::get("Seasons")
			->find()->where(["Seasons.id" => $season_id])->all()->first())) {
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
				"season_id" => $season_id,
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
			"season_id" => $season_id,
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

	function apiRemoveseason($seat, $season) {

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
				"season_id" => $season,
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

	function apiRemoveItem($id) {

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
				"id" => $id,
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
