<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Network\Exception\NotFoundException;

/**
 * Theaters Controller
 */
class PerformancesController extends AppController {

	public function index($mode = "open")
	{

		// Do some setup for the view
		$this->viewBuilder()->layout("site");
		$this->set("css", ["site"]);

		// Pass the mode to the view
		$this->set("mode", $mode);

		// Set the list of tabs for the view
		$this->set("tabs", [
			["open", "Seats Available", "left"],
			["closed", "Sold Out", "left"],
			["finished", "Concluded", "left"],
			["all", "All Performances", "left"],
			["season", "Season Tickets", "right"],
		]);

		if ($mode == "season") {

			$this->set("seasons", TableRegistry::get("Seasons")
				->find()
				->where(["start_time < " => time(), "end_time > " => time()])
				->all());

			$this->set("past_seasons", TableRegistry::get("Seasons")
				->find()
				->where(["end_time < " => time()])
				->all());

		} else {

			// Select a list of plays, including their performances
			$plays = TableRegistry::get("Plays")
				->find()
				->contain(["Performances", "Performances.Theaters", "Performances.Tickets", "Performances.Theaters.Seats"])
				->all();

			// Build the 'pass' list to pass to the view
			$pass = [];
			foreach ($plays as $play) {

				// Build the list of performances
				$performances = [];
				foreach ($play->performances as $performance) {

					// Compute the number of available seats
					$available = count($performance->theater->seats) - count($performance->tickets);

					// Determine whether or not to show this performance
					$show = (
						($mode == "open" && $available > 0 && $performance->start_time > time()) ||
						($mode == "closed" && $available < 1) ||
						($mode == "finished" && $performance->start_time < time()) ||
						($mode == "all")
					);

					// If it should be shown, add to performance list
					if ($show) $performances[] = [
						$performance->id,
						date("M d Y, h:i", $performance->start_time),
						$performance->theater->name,
						$available,
						$play->name
					];
				}

				// Add to the pass array if there are performances
				if (count($performances > 0)) $pass[] = [
					$play->artwork,
					$play->name,
					$performances
				];
			}

			// Pass the list of plays to the view
			$this->set("plays", $pass);

		}

	}

	public function view($id, $slug = "", $row = -1) {

		// Set the layout template
		$this->viewBuilder()->layout("site");
		$this->set("css", ["site"]);

		// Get the table ready for queries
		$table = TableRegistry::get("Performances");
		$cartTable = TableRegistry::get("CartItems");

		// Select the performance and other info from the database
		$performances = $table
			->find()
			->where(["Performances.id" => $id])
			->contain([
				"Theaters", "Tickets", "Theaters.Sections",
				"Theaters.Sections.Rows", "Theaters.Sections.Rows.Seats",
				"Plays"
			])
			->all();

		// Load the user's shopping cart
		$cart = $cartTable
			->find()
			->where([
				"cart_id" => $this->Cookie->read("ta_cart_id"),
				"performance_id" => $id
			])
			->all();

		// Display an error if this performance does not exist
		if ($performances->count() < 1) {
			throw new NotFoundException();
		}

		// Get the first performance result
		$performance = $performances->first();

		// Set the main parameters for the view
		$this->set("performance_id", $id);
		$this->set("play_id", $performance->play->artwork);
		$this->set("play_name", $performance->play->name);
		$this->set("play_theater", $performance->theater->name);
		$this->set("play_date", date("M d Y", $performance->start_time));
		$this->set("play_time", date("h:i a", $performance->start_time));
		$this->set("play_slug", $performance->play->artwork);
		$this->set("play_about", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam pharetra bibendum interdum. Etiam convallis leo quis ipsum rhoncus egestas. Ut a est vel urna cursus feugiat et sagittis enim. Sed lectus arcu, sagittis nec urna in, ultrices hendrerit massa. Quisque rutrum efficitur scelerisque. Fusce non convallis ex, sagittis elementum eros. Suspendisse mattis, velit vel pellentesque varius, felis leo gravida magna, vel dignissim arcu ipsum vel diam. Etiam suscipit felis mi, at facilisis tellus pulvinar et.");

		// Build the available seat structure
		$sections = [];
		foreach ($performance->theater->sections as $section) {
			$rows = [];

			// For each row in the theater...
			foreach ($section->rows as $r) {

				// Set up a few arrays to populate with seats
				$seat_names = [];
				$seat_prices = [];
				$seat_ids = [];
				$seat_cart_statuses = [];
				$seat_count = 0;

				// For each seat in the theater
				foreach ($r->seats as $seat) {

					// Determine whether this seat is available
					$available = true;
					foreach ($performance->tickets as $ticket) {
						if ($ticket->seat_id == $seat->id) {
							$available = false;
						}
					}

					$cart_status = false;
					foreach ($cart as $item) {
						if ($item->seat_id == $seat->id) {
							$cart_status = true;
						}
					}

					// Add the seat to the structure
					$seat_names[] = $section->code.$r->code."-".$seat->code;
					$seat_prices[] = (($available) ? $seat->price : false);;
					$seat_ids[] = $seat->id;
					$seat_cart_statuses[] = $cart_status;

					// Increment the seat count if available
					$seat_count += (($available) ? 1 : 0);
				}

				// Add to the list of rows
				$rows[] = [$r->code, $seat_count, $seat_names, $seat_prices, $seat_ids, $seat_cart_statuses, $performance->id];
			}

			// Add to the list of sections
			$sections[] = [$section->front_text, $section->back_text, $rows];
		}

		// If no row selected, select the first row with open seats.
		if ($row == -1) {
			$i = 0;
			foreach ($sections as $sec) {
				foreach ($sec[2] as $r2) {
					foreach ($r2[3] as $seat)
						if ($seat) {
							$row = $i;
							break 2;
						}
					$i++;
				}
			}

			// If no row has available seats, set to first
			if ($row == -1) $row = 0;
		}

		// Set a few more view parameters.
		$this->set("selected_row", $row);
		$this->set("sections", $sections);
		$this->set("seat_options", []);
		$this->set("ready_for_checkout", $cart->count() > 0);

		// Load the selected row and pass it to the view.
		$i = 0;
		foreach ($sections as $sec) {
			foreach ($sec[2] as $r) {
				if ($row == $i) {
					$this->set("seat_options", $r);
					break 2;
				}
				$i++;
			}
		}

	}


}