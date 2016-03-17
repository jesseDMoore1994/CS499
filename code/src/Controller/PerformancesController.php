<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Theaters Controller
 */
class PerformancesController extends AppController {

	public function index()
	{

	}

	public function view($theater_id, $theater_slug)
	{

		$this->viewBuilder()->layout("site");
		$this->set("css", ["site"]);

		if ($theater_id == "ccch") {

			$this->set("theater_id", "ccch");
			$this->set("theater_name", "Civic Center Conference Hall");
			$this->set("theater_location", "Von Braun Civic Center. Huntsville, Alabama.");
			$this->set("theater_about", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse rhoncus lobortis nisi, et suscipit mi malesuada eget. Vivamus eu urna neque. Phasellus felis orci, commodo in felis id, aliquam placerat nibh. Suspendisse viverra a elit id condimentum. Integer vestibulum tristique augue vitae rutrum. Etiam et vehicula ipsum, sed faucibus lacus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur tempus a arcu et interdum. Vivamus auctor malesuada lectus, vel bibendum orci finibus in. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Etiam rutrum viverra elit eu eleifend. Pellentesque vestibulum augue purus, vel maximus nunc porttitor in. Aenean vel nisi at ante euismod placerat vitae vel velit. Morbi accumsan orci quis nulla semper rhoncus. Aliquam erat volutpat. Nullam sit amet nunc dictum, iaculis risus non, aliquet purus.");

			$this->set("theater_performances", [
				["Macbeth", "William Shakespeare", "January 4th 2016", "10:00 PM"],
				["Macbeth", "William Shakespeare", "January 4th 2016", "10:00 PM"],
				["Macbeth", "William Shakespeare", "January 4th 2016", "10:00 PM"],
				["Macbeth", "William Shakespeare", "January 4th 2016", "10:00 PM"],
			]);

		} else if ($theater_id == "ccph") {

			$this->set("theater_id", "ccph");
			$this->set("theater_name", "Civic Center Playhouse");
			$this->set("theater_location", "Von Braun Civic Center. Huntsville, Alabama.");
			$this->set("theater_about", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse rhoncus lobortis nisi, et suscipit mi malesuada eget. Vivamus eu urna neque. Phasellus felis orci, commodo in felis id, aliquam placerat nibh. Suspendisse viverra a elit id condimentum. Integer vestibulum tristique augue vitae rutrum. Etiam et vehicula ipsum, sed faucibus lacus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur tempus a arcu et interdum. Vivamus auctor malesuada lectus, vel bibendum orci finibus in. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Etiam rutrum viverra elit eu eleifend. Pellentesque vestibulum augue purus, vel maximus nunc porttitor in. Aenean vel nisi at ante euismod placerat vitae vel velit. Morbi accumsan orci quis nulla semper rhoncus. Aliquam erat volutpat. Nullam sit amet nunc dictum, iaculis risus non, aliquet purus.");

			$this->set("theater_performances", [
				["Macbeth", "William Shakespeare", "January 4th 2016", "10:00 PM"],
				["Macbeth", "William Shakespeare", "January 4th 2016", "10:00 PM"],
				["Macbeth", "William Shakespeare", "January 4th 2016", "10:00 PM"],
				["Macbeth", "William Shakespeare", "January 4th 2016", "10:00 PM"],
			]);

		}

	}

}