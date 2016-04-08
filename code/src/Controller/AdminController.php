<?php

namespace App\Controller;

use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Symfony\Component\Config\Definition\Exception\Exception;
use Cake\Network\Exception\ForbiddenException;

class AdminController extends AppController {

	function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->viewBuilder()->layout('admin');

		// Display an error if the user is not logged in
		if (!($this->loggedIn && $this->admin)) {
			throw new ForbiddenException();
		}

		// Handle selection of the admin control panel
		if (count($this->adminTheaters) == 0 && !$this->superAdmin) {

			// Do nothing if the user is not a theater admin

		} else if ($this->Cookie->read('ta_theater_admin') == null) {

			// If none set, Set the admin to be viewing the admin panel for their first assigned theater
			if ($this->superAdmin) {
				$this->adminTheater = 0;
			} else {
				$this->Cookie->write("ta_theater_admin", $this->adminTheaters[0]->theater_id);
				$this->adminTheater = $this->adminTheaters[0]->theater_id;
			}

		} else if ($this->Cookie->read('ta_theater_admin') == 0) {

			// Set the user as having selected the super admin console
			if ($this->superAdmin) {
				$this->adminTheater = 0;
			} else {
				// If not allowed, set the panel as the first allowed panel again
				$this->Cookie->write("ta_theater_admin", $this->adminTheaters[0]->theater_id);
				$this->adminTheater = $this->adminTheaters[0]->theater_id;
			}

		} else if ($this->superAdmin) {

			// Read the theater from the cookie directly
			$this->adminTheater = $this->Cookie->read('ta_theater_admin');

		} else {

			// If the user has a panel selected, verify
			$selected = $this->Cookie->read('ta_theater_admin');
			$found = false;

			// Search through allowed theaters to find the selected
			foreach ($this->adminTheaters as $theater) {
				if ($theater->theater_id == $selected) {
					$this->adminTheater = $theater->theater_id;
					$found = true;
					break;
				}
			}

			// If none found, reset to first allowed
			if (!$found) {
				$this->Cookie->write("ta_theater_admin", $this->adminTheaters[0]->theater_id);
				$this->adminTheater = $this->adminTheaters[0]->theater_id;
			}

		}

		// Set default permissions
		$this->canCashier = false;
		$this->canManage = false;

		// Calculate the current permissions
		if ($this->superAdmin) {
			$this->canCashier = true;
			$this->canManage = true;
		} else {
			foreach ($this->adminTheaters as $theater) {
				if ($theater->theater_id == $this->adminTheater) {
					$this->canCashier = $theater->access_level >= 1;
					$this->canManage = $theater->access_level >= 2;
					break;
				}
			}
		}

		// Pass the current permissions to the view
		$this->set("adminTheater", $this->adminTheater);
		$this->set("canCashier", $this->canCashier);
		$this->set("canManage", $this->canManage);

	}
}
