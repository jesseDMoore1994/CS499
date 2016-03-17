<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Theaters Controller
 */
class TheatersController extends AppController {

	public function index()
	{

		$this->viewBuilder()->layout("site");
		$this->set("css", ["site"]);

		$this->set("theaters", [
			["ccph", "civic-center-playhouse", "Civic Center Playhouse", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ut sem dapibus, fermentum neque quis, tincidunt massa. Pellentesque vel elementum turpis. Quisque id elementum ante. Mauris sit amet ipsum consequat, maximus risus id, porta enim."],
			["ccch", "civic-center-conference-hall", "Civic Center Conference Hall", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ut sem dapibus, fermentum neque quis, tincidunt massa. Pellentesque vel elementum turpis. Quisque id elementum ante. Mauris sit amet ipsum consequat, maximus risus id, porta enim."]
		]);

	}

}