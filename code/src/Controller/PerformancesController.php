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

	public function view($id, $slug) {

		$this->viewBuilder()->layout("site");
		$this->set("css", ["site"]);

		$this->set("play_id", "othello");
		$this->set("play_name", "The Tragedy of Othello, the Moor of Venice");
		$this->set("play_theater", "Civic Center Concert Hall");
		$this->set("play_date", "January 6th, 2016");
		$this->set("play_time", "10:00 pm");
		$this->set("play_about", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam pharetra bibendum interdum. Etiam convallis leo quis ipsum rhoncus egestas. Ut a est vel urna cursus feugiat et sagittis enim. Sed lectus arcu, sagittis nec urna in, ultrices hendrerit massa. Quisque rutrum efficitur scelerisque. Fusce non convallis ex, sagittis elementum eros. Suspendisse mattis, velit vel pellentesque varius, felis leo gravida magna, vel dignissim arcu ipsum vel diam. Etiam suscipit felis mi, at facilisis tellus pulvinar et.");

	}


}