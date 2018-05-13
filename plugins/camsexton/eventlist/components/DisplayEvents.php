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
		$this->upcomingEvents = Db::select("SELECT 
			title, 
			venue,
			CASE strftime('%w', datetime) when '0' then 'Sunday' when '1' then 'Monday' when '2' then 'Tuesday' when '3' then 'Wednesday' when '4' then 'Thursday' when '5' then 'Friday' when '6' then 'Saturday' end as day, 
			strftime('%d', datetime) as date,
			CASE strftime('%m', datetime) when '01' then 'January' when '02' then 'Febuary' when '03' then 'March' when '04' then 'April' when '05' then 'May' when '06' then 'June' when '07' then 'July' when '08' then 'August' when '09' then 'September' when '10' then 'October' when '11' then 'November' when '12' then 'December' else '' end as month,
			CASE WHEN (strftime('%H', datetime) > '13') THEN (strftime('%H', datetime) - '12') WHEN (strftime('%H', datetime) = '00') THEN '12' ELSE (strftime('%H', datetime) - '0') END as hour,
			strftime('%M', datetime) as minute,
			CASE WHEN (strftime('%H', datetime) >= '12') THEN 'pm' ELSE 'am' end as ampm,
			description 
			FROM camsexton_eventlist_events 
			WHERE datetime > datetime('now')
			ORDER BY datetime ASC
		");
		$this->pastEvents = Db::select("SELECT 
			title, 
			venue,
			CASE strftime('%w', datetime) when '0' then 'Sunday' when '1' then 'Monday' when '2' then 'Tuesday' when '3' then 'Wednesday' when '4' then 'Thursday' when '5' then 'Friday' when '6' then 'Saturday' end as day, 
			strftime('%d', datetime) as date,
			CASE strftime('%m', datetime) when '01' then 'January' when '02' then 'Febuary' when '03' then 'March' when '04' then 'April' when '05' then 'May' when '06' then 'June' when '07' then 'July' when '08' then 'August' when '09' then 'September' when '10' then 'October' when '11' then 'November' when '12' then 'December' else '' end as month,
			CASE WHEN (strftime('%H', datetime) > '13') THEN (strftime('%H', datetime) - '12') WHEN (strftime('%H', datetime) = '00') THEN '12' ELSE (strftime('%H', datetime) - '0') END as hour,
			strftime('%M', datetime) as minute,
			CASE WHEN (strftime('%H', datetime) >= '12') THEN 'pm' ELSE 'am' end as ampm,
			description 
			FROM camsexton_eventlist_events 
			WHERE datetime < datetime('now')
			ORDER BY datetime DESC
		");
	}
	public $upcomingEvents;
	public $pastEvents;
	
}
