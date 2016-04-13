<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;

/**
 * Theaters Controller
 */
class SeasonController extends AppController {

	public function view($season_id, $row = -1) {

		$this->viewBuilder()->layout("site");
		$this->set("css", ["site"]);

		// Get the table ready for queries
		$table = TableRegistry::get("Seasons");
		$cartTable = TableRegistry::get("CartItems");

		// Select the performance and other info from the database
		$seasons = $table->find()
			->where(["Seasons.id" => $season_id])
			->contain([
				"Theaters", "Theaters.Sections",
				"Theaters.Sections.Rows",
				"Theaters.Sections.Rows.Seats",

			])
			->all();

		if ($seasons->count() == 0)
			throw new NotFoundException();

		$season = $seasons->first();

		// Load the user's shopping cart
		$cart = $cartTable
			->find()
			->where([
				"cart_id" => $this->Cookie->read("ta_cart_id"),
				"season_id" => $season_id
			])
			->all();

		// Set the main parameters for the view
		$this->set("season", $season);

		// Build the available seat structure
		$sections = [];
		foreach ($season->theater->sections as $section) {
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
					$available = $seat->isAvailableSeason($season);

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
				$rows[] = [$r->code, $seat_count, $seat_names, $seat_prices, $seat_ids, $seat_cart_statuses, $season->id];
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