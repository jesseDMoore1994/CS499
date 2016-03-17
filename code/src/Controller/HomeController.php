<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

class HomeController extends AppController {
	function index() {
		$this->viewBuilder()->layout("default");
		$this->set("css", ["home"]);

		$this->set("banner_image", "carol");
		$this->set("banner_title", "A Christmas Carol");
		$this->set("banner_subtitle", "Tickets now on sale. Civic Center Playhouse. Huntaville, Alabama.");

		$this->set("performances", [
			["othello", "Othello", "Civic Center Concert Hall", "January 2nd, 2016. 10:00pm"],
			["macbeth", "Macbeth", "Civic Center Concert Hall", "January 2nd, 2016. 10:00pm"],
		]);
	}
}