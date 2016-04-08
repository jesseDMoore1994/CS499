<?php

namespace App\Controller;

use Cake\Core\Configure;

class AdminSettingsController extends AdminController {
	public function select($panel) {
		$this->Cookie->write("ta_theater_admin", $panel);
		return $this->redirect("/admin/");
	}
}