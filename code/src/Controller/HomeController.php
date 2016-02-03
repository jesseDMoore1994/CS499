<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

class HomeController extends AppController {
	function index() {
		$this->viewBuilder()->layout("html");
	}
}