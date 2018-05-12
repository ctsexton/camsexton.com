<?php namespace CamSexton\EventList\Components;

use Cms\Classes\ComponentBase;
use Db;

class DisplayEvents extends ComponentBase

{
	public function componentDetails() {
		return [
			'name' => 'Display Events',
			'description' => 'Display events listed in database'
		];
	}

	public function onRun() {
		$this->upcomingEvents = Db::select("SELECT * FROM camsexton_eventlist_events WHERE datetime > datetime('now')");
		$this->pastEvents = Db::select("SELECT * FROM camsexton_eventlist_events WHERE datetime < datetime('now')");
	}
	public $upcomingEvents;
	public $pastEvents;
	
}
