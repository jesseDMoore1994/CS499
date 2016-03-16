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

	}

}