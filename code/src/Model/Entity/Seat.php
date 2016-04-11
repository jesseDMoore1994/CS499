<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

class Seat extends Entity
{
	protected $_accessible = [
		'*' => true,
	];

	public function isAvailablePerformance($performance) {
		// Check for season tickets that conflict
		$tickets_season = TableRegistry::get("Tickets")
			->find()
			->where(["season_id" => $performance->season_id, "seat_id" => $this->id])
			->all();

		if ($tickets_season->count() > 0)
			return false;

		// Check for performance tickets that conflict
		$performances = TableRegistry::get("Performances")
			->find()
			->where(["season_id" => $performance->season_id])
			->contain("Tickets")
			->all();

		foreach ($performances as $performance) {
			foreach ($performance->tickets as $ticket) {
				if ($ticket->seat_id == $this->id)
					return false;
			}
		}

		return true;
	}

	public function isAvailableSeason($season) {
		// Check for season tickets that conflict
		$tickets_season = TableRegistry::get("Tickets")
			->find()
			->where(["season_id" => $season->id, "seat_id" => $this->id])
			->all();

		if ($tickets_season->count() > 0)
			return false;

		// Check for performance tickets that conflict
		$performances = TableRegistry::get("Performances")
			->find()
			->where(["season_id" => $season->id])
			->contain("Tickets")
			->all();

		foreach ($performances as $performance) {
			foreach ($performance->tickets as $ticket) {
				if ($ticket->seat_id == $this->id)
					return false;
			}
		}

		return true;

	}
}
