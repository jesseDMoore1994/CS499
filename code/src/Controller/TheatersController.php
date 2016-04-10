<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\NotFoundException;
use Cake\ORM\TableRegistry;

/**
 * Theaters Controller
 */
class TheatersController extends AppController {

	public function index()
	{

		$this->viewBuilder()->layout("site");
		$this->set("css", ["site"]);

		$this->set("theaters", [
			["1", "ccph", "civic-center-playhouse", "Civic Center Playhouse", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ut sem dapibus, fermentum neque quis, tincidunt massa. Pellentesque vel elementum turpis. Quisque id elementum ante. Mauris sit amet ipsum consequat, maximus risus id, porta enim."],
			["2", "ccch", "civic-center-concert-hall", "Civic Center Conference Hall", "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ut sem dapibus, fermentum neque quis, tincidunt massa. Pellentesque vel elementum turpis. Quisque id elementum ante. Mauris sit amet ipsum consequat, maximus risus id, porta enim."]
		]);

	}

	public function view($theater_id, $theater_slug)
	{

		$this->viewBuilder()->layout("site");
		$this->set("css", ["site"]);

		$table = TableRegistry::get("Theaters");
		$theater = $table
			->find()
			->where(["id" => $theater_id])
			->contain(["Performances", "Performances.Plays"])
			->all();

		if ($theater->count() > 0) {
			$theater = $theater->first();
		} else {
			throw new NotFoundException();
		}

		$this->set("theater_id", $theater->id);
		$this->set("theater_artwork", $theater->artwork);
		$this->set("theater_name", $theater->name);
		$this->set("theater_location", $theater->location);
		$this->set("theater_about", $theater->description);

		$perf = [];
		foreach ($theater->performances as $performance) {
			$perf[] = [
				$performance->play->name,
				$performance->play->author,
				date("M d Y", $performance->start_time),
				date("h:i a", $performance->start_time),
				$performance->id,
				$performance->artwork
			];
		}

		$this->set("theater_performances", $perf);
	}

}