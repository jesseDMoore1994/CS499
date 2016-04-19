<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;
use Cake\View\Exception\MissingTemplateException;

class HomeController extends AppController {
	function index() {
		$this->viewBuilder()->layout("default");
		$this->set("css", ["home"]);

		$this->set("banner_image", "carol");
		$this->set("banner_title", "A Christmas Carol");
		$this->set("banner_subtitle", "Tickets now on sale. Civic Center Playhouse. Huntaville, Alabama.");
		$this->set("banner_link", "/performances/view/10/carol/");

		$table = TableRegistry::get("Performances");
		$performances = $table
			->find()
			->where([
				"start_time > " => time(),
				"open" => "1",
				"canceled" => "0"
			])
			->contain([
				"Plays", "Theaters"
			])
			->orderAsc("start_time")
			->all();

		$data = [];
		foreach ($performances as $performance) {
			$data[] = [
				$performance->play->artwork,
				$performance->play->name,
				$performance->theater->name,
				date("M d Y, h:i", $performance->start_time),
				"/performances/view/".$performance->id."/".$performance->play->artwork."/",
				$performance->play->shortname
			];
		}

		$this->set("performances", $data);
	}
}