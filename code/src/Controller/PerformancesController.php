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
				[1, "January 2nd, 2016, 10:00pm", "Civic Center Concert Hall", 10],
				[2, "January 2nd, 2016, 10:00pm", "Civic Center Concert Hall", 10],
				[3, "January 2nd, 2016, 10:00pm", "Civic Center Concert Hall", 10],
				[4, "January 2nd, 2016, 10:00pm", "Civic Center Concert Hall", 10],
			]],
			["macbeth", "The Tragedy of Macbeth", [
				[1, "January 2nd, 2016, 10:00pm", "Civic Center Concert Hall", 10],
				[2, "January 2nd, 2016, 10:00pm", "Civic Center Concert Hall", 10],
			]],
		]);

	}

	public function view($id, $slug) {

	}


}