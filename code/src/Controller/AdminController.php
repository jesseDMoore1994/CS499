<?php

namespace App\Controller;

use Cake\Event\Event;

class AdminController extends AppController {
	function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->viewBuilder()->layout('admin');
	}
}
