<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Theaters Controller
 */
class PerformancesController extends AppController {

	public function index($mode = "open")
	{

		$this->viewBuilder()->layout("site");
		$this->set("css", ["site"]);

		$this->set("mode", $mode);

		$this->set("tabs", [
			["open", "Seats Available", "left"],
			["closed", "Sold Out", "left"],
			["finished", "Concluded", "left"],
			["all", "All Performances", "left"],
			["season", "Season Tickets", "right"],
		]);

		$this->set("plays", [
			["othello", "The Tragedy of Othello, the Moor of Venice", [
				[1, "January 2nd, 2016, 10:00pm", "Civic Center Concert Hall", 10, "the-tragedy-of-othello-the-moor-of-venice"],
				[2, "January 2nd, 2016, 10:00pm", "Civic Center Concert Hall", 10, "the-tragedy-of-othello-the-moor-of-venice"],
				[3, "January 2nd, 2016, 10:00pm", "Civic Center Concert Hall", 10, "the-tragedy-of-othello-the-moor-of-venice"],
				[4, "January 2nd, 2016, 10:00pm", "Civic Center Concert Hall", 10, "the-tragedy-of-othello-the-moor-of-venice"],
			]],
			["macbeth", "The Tragedy of Macbeth", [
				[1, "January 2nd, 2016, 10:00pm", "Civic Center Concert Hall", 10, "the-tragedy-of-macbeth"],
				[2, "January 2nd, 2016, 10:00pm", "Civic Center Concert Hall", 10, "the-tragedy-of-macbeth"],
			]],
		]);

	}

	public function view($id, $slug, $row = -1) {

		// Set the layout template
		$this->viewBuilder()->layout("site");
		$this->set("css", ["site"]);

		// Set the main parameters for the view
		$this->set("performance_id", $id);
		$this->set("play_id", "othello");
		$this->set("play_name", "The Tragedy of Othello, the Moor of Venice");
		$this->set("play_theater", "Civic Center Concert Hall");
		$this->set("play_date", "January 6th, 2016");
		$this->set("play_time", "10:00 pm");
		$this->set("play_slug", $slug);
		$this->set("play_about", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam pharetra bibendum interdum. Etiam convallis leo quis ipsum rhoncus egestas. Ut a est vel urna cursus feugiat et sagittis enim. Sed lectus arcu, sagittis nec urna in, ultrices hendrerit massa. Quisque rutrum efficitur scelerisque. Fusce non convallis ex, sagittis elementum eros. Suspendisse mattis, velit vel pellentesque varius, felis leo gravida magna, vel dignissim arcu ipsum vel diam. Etiam suscipit felis mi, at facilisis tellus pulvinar et.");

		// Define the theater's seats
		$sections = [
			["Front", "Back", [
				["A", 0, ["A1", "A2", "A3", "A4", "A5"], [false, false, false, false, false]],
				["B", 2, ["B1", "B2", "B3", "B4", "B5"], [15, 15, false, false, false]],
				["C", 5, ["C1", "C2", "C3", "C4", "C5"], [15, 15, 15, 15, 15]],
			]],
			["Balcony", "&nbsp;", [
				["U", 5, ["U1", "U2", "U3", "U4", "U5"], [15, 15, 15, 15, 15]],
				["V", 5, ["V1", "V2", "V3", "V4", "V5"], [15, 15, 15, 15, 15]],
				["W", 5, ["W1", "W2", "W3", "W4", "W5"], [15, 15, 15, 15, 15]],
			]],
			["&nbsp;", "&nbsp;", [
				["<span class='icomoon'>&#xe9b2;</span>", 2, ["AC1", "AC2", "AC3", "AC4", "AC5"], [false, false, 15, 15, false]],
			]]
		];

		// If no row selected, select the first row with open seats.
		if ($row == -1) {
			$i = 0;
			foreach ($sections as $sec) {
				foreach ($sec[2] as $r) {
					foreach ($r[3] as $seat)
						if ($seat) {
							$row = $i;
							break 2;
						}
					$i++;
				}
			}

			if ($row == -1) $row = 0;
		}

		// Set a few more view parameters.
		$this->set("selected_row", $row);
		$this->set("sections", $sections);
		$this->set("seat_options", []);

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