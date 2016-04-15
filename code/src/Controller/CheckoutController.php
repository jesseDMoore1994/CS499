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

		$season_cart = false;

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

		if ($cart->count() < 1) {
			return $this->redirect("/cart/");
		}

		$pass = [];

		foreach ($cart as $item) {
			$pass[] = [
				($item->performance == null) ? $item->season->ticket_price : $item->seat->price,
				($item->performance == null) ? $item->season->name : $item->performance->play->name,
				($item->performance == null) ? $item->season->theater->name : $item->performance->theater->name,
				($item->performance == null) ? date("M d Y", $item->season->start_time) : date("M d Y", $item->performance->start_time),
				($item->performance == null) ? date("h:i", $item->season->start_time) : date("h:i", $item->performance->start_time),
				$item->seat->row->section->code.
				$item->seat->row->code.
				"-".
				$item->seat->code,
				$item->seat->id,
				($item->performance == null) ? $item->season->id : $item->performance->id,
				$item->id
			];

			if ($item->season_id != 0) {
				$season_cart = true;
			}
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
		$this->set("season_cart", $season_cart);
	}

	public function process()
	{

		$method = $this->request->data("payment-method");
		$name = "";

		if ($method == "credit") {
			$name = $this->request->data("card-name");
		} else {
			$name = $this->request->data("name");
		}

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
				"Seasons", "Seasons.Theaters"
			])
			->all();

		// fetch account info
		$account_name = $this->request->data("account_name");
		$account_email = $this->request->data("account_email");
		$account_password = $this->request->data("account_password");
		$account_password_confirm = $this->request->data("account_password_confirm");

		// fetch address info
		$street = $this->request->data("account_address");
		$city = $this->request->data("account_city");
		$state = $this->request->data("account_state");
		$country = $this->request->data("account_country");
		$zip = $this->request->data("account_zipcode");
		$phone = $this->request->data("account_phone");

		// Perform account management operations
		if ($this->loggedIn && $street != null && $street != "") {

			// Update account with address
			$this->user->street = $street;
			$this->user->city = $city;
			$this->user->state = $state;
			$this->user->country = $country;
			$this->user->zip = $zip;
			$this->user->phone_number = $phone;
			TableRegistry::get("Users")->save($this->user);

		} else if ($account_name != null && $account_name != "") {

			// Make sure the password and confirmation match
			if ($account_password != $account_password_confirm) {
				$this->Flash->set("The password you entered does not match the confirmation.", [
					'element' => 'error'
				]);
				return $this->redirect("/checkout/");
			}

			// Generate the salt
			$salt = uniqid(mt_rand(), true);
			$tbl = TableRegistry::get("Users");

			// Create the new account
			$user = $tbl->newEntity([
				"name" => $account_name,
				"email" => $account_email,
				"password" => pbkdf2("sha256", $account_password, $salt),
				"salt" => $salt,
				"street" => $street,
				"city" => $city,
				"state" => $state,
				"country" => $country,
				"zip" => $zip,
				"phone_number" => $phone
			]);

			// Save the user
			$tbl->save($user);

			// Log the new user in
			$key = $user->makeKey();
			$this->Cookie->write('ta_login_id', $user->id);
			$this->Cookie->write('ta_login_email', $user->email);
			$this->Cookie->write('ta_login_key', $key);

		}

		// Redirect if the cart is empty
		if ($cart->count() < 1) {
			return $this->redirect("/cart/");
		}

		$purchase_id = uniqid("", true).".".dechex(mt_rand(0,9999999999));

		$success = true;

		// For each item in the cart
		foreach ($cart as $item) {
			if ($item->season_id == 0) {

				// Check to see whether this ticket was already purchased
				if (!$item->seat->isAvailablePerformance(TableRegistry::get("Performances")
					->find()->where(["Performances.id" => $item->performance_id])->contain(["Seasons"])->all()->first())) {

					// Delete the ticket from the cart
					$table->delete($item);

					// Display an error to the user
					$this->Flash->set("The seat ".$item->seat->row->section->code.$item->seat->row->code."-".$item->seat->code." has already been taken.", [
						'element' => 'error'
					]);

					// Redirect back to the view cart page
					return $this->redirect("/cart/");

				}

				// Create the ticket
				$ticket = $ticketTable->newEntity([
					"theater_id" => $item->performance->theater->id,
					"section_id" => $item->seat->row->section->id,
					"row_id" => $item->seat->row->id,
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

			} else {

				// Check to see whether this season ticket was already purchased
				if (!$item->seat->isAvailableSeason(TableRegistry::get("Seasons")
					->find()->where(["Seasons.id" => $item->season_id])->all()->first())) {

					// Delete the ticket from the cart
					$table->delete($item);

					// Display an error to the user
					$this->Flash->set("The seat ".$item->seat->row->section->code.$item->seat->row->code."-".$item->seat->code." has already been taken.", [
						'element' => 'error'
					]);

					// Redirect back to the view cart page
					return $this->redirect("/cart/");

				}

				// Create the ticket
				$ticket = $ticketTable->newEntity([
					"theater_id" => $item->season->theater->id,
					"section_id" => $item->seat->row->osection->id,
					"row_id" => $item->seat->oow->id,
					"seat_id" => $item->seat->id,
					"status" => "paid",
					"customer_id" => (($item->loggedIn) ? $item->user->id : 0),
					"customer_name" => (($item->loggedIn) ? $item->user->name : $name),
					"ticket_number" => bin2hex($item->season_id.":".$item->seat->id),
					"season_id" => $item->season_id,
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
			->contain(['Seats', 'Rows', 'Sections', 'Performances', 'Theaters', 'Performances.Plays', "Seasons", "Seasons.Theaters"])
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
			->contain(['Seats', 'Rows', 'Sections', 'Performances', 'Theaters', 'Performances.Plays', "Seasons", "Seasons.Theaters"])
			->all();

		$this->set("tickets", $purchase);
	}
}
