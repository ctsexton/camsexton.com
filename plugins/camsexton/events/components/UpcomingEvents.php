<?php namespace CamSexton\Events\Components;

use Cms\Classes\ComponentBase;
use Db;

class UpcomingEvents extends ComponentBase

{
	public function componentDetails() {
		return [
			'name' => 'Upcoming Events',
			'description' => 'Display upcoming events from database'
		];
	}

	public function onRun() {
		$this->queryEvents();
	}

	public $events;

	protected function queryEvents() {
		$this->events = Db::select("SELECT 
			title, 
			venue,
			CASE strftime('%w', date_time) when '0' then 'Sunday' when '1' then 'Monday' when '2' then 'Tuesday' when '3' then 'Wednesday' when '4' then 'Thursday' when '5' then 'Friday' when '6' then 'Saturday' end as day, 
			strftime('%d', date_time) as date,
			CASE strftime('%m', date_time) when '01' then 'January' when '02' then 'Febuary' when '03' then 'March' when '04' then 'April' when '05' then 'May' when '06' then 'June' when '07' then 'July' when '08' then 'August' when '09' then 'September' when '10' then 'October' when '11' then 'November' when '12' then 'December' else '' end as month,
			CASE WHEN (strftime('%H', date_time) > '13') THEN (strftime('%H', date_time) - '12') WHEN (strftime('%H', date_time) = '00') THEN '12' ELSE (strftime('%H', date_time) - '0') END as hour,
			strftime('%M', date_time) as minute,
			CASE WHEN (strftime('%H', date_time) >= '12') THEN 'pm' ELSE 'am' end as ampm,
			description 
			FROM camsexton_events_entries
			WHERE date_time > datetime('now')
			ORDER BY date_time ASC
		");
	}
}
