<?php namespace CamSexton\EventList\Components;

use Cms\Classes\ComponentBase;
use Db;
use Schema;
use DateTime;
use DateTimeZone;

class UpcomingEvents extends ComponentBase

{
	public function componentDetails() {
		return [
			'name' => 'Upcoming Events',
			'description' => 'Display upcoming events from database'
		];
	}
/*
	public $thejson;

	public function onRun() {
		$json = $this->constructRequest();
		$this->updateDb($json);
		$this->queryEvents();
	}

	public $events;

	protected function queryEvents() {
		$this->events = Db::select("SELECT 
			title, 
			venue,
			CASE strftime('%w', datetime) when '0' then 'Sunday' when '1' then 'Monday' when '2' then 'Tuesday' when '3' then 'Wednesday' when '4' then 'Thursday' when '5' then 'Friday' when '6' then 'Saturday' end as day, 
			strftime('%d', datetime) as date,
			CASE strftime('%m', datetime) when '01' then 'January' when '02' then 'Febuary' when '03' then 'March' when '04' then 'April' when '05' then 'May' when '06' then 'June' when '07' then 'July' when '08' then 'August' when '09' then 'September' when '10' then 'October' when '11' then 'November' when '12' then 'December' else '' end as month,
			CASE WHEN (strftime('%H', datetime) > '13') THEN (strftime('%H', datetime) - '12') WHEN (strftime('%H', datetime) = '00') THEN '12' ELSE (strftime('%H', datetime) - '0') END as hour,
			strftime('%M', datetime) as minute,
			CASE WHEN (strftime('%H', datetime) >= '12') THEN 'pm' ELSE 'am' end as ampm,
			description 
			FROM camsexton_googleCal_events 
			ORDER BY datetime ASC
		");
	}

	protected function requestCal($URL) {
		$data = @file_get_contents($URL);
		if ($data === false) {
			file_put_contents('php://stderr', print_r("JSON DATA FALSE\n", TRUE));
			return 1;
		}
		$json = json_decode($data, true);

		// json is an associative array

		if (isset($json['error'])) {
			file_put_contents('php://stderr', print_r("JSON error\n", TRUE));
			return 1;
		}
		else {
			file_put_contents('php://stderr', print_r("Successfully got JSON\n", TRUE));
			return $json;
		}
	}

	protected function constructRequest() {
		// load env variables
		$API_KEY = config("api.GCAL_API_KEY");
		$calendarID = config("api.GCAL_ID");
		$timeZone = config("api.GCAL_TIMEZONE");
		
		$today = new DateTime();
		$today->setTimezone(new DateTimeZone($timeZone));
		$timeMin = rawurlencode($today->format('Y-m-d') . 'T00:00:00' . $today->format('O'));

		// Construct GET request URL
		$requestURL = 'https://www.googleapis.com/calendar/v3/calendars/' 
			. $calendarID 
			. '%40group.calendar.google.com/events?orderBy=startTime&singleEvents=true&timeMin=' 
			. $timeMin 
			. '&key=' 
			. $API_KEY;
		
		$requestAllURL = 'https://www.googleapis.com/calendar/v3/calendars/' 
			. $calendarID 
			. '%40group.calendar.google.com/events?orderBy=startTime&singleEvents=true' 
			. '&key=' 
			. $API_KEY;

		// GET request URL and convert JSON string to PHP object

		$json = $this->requestCal($requestAllURL);
		if ($json === 1) {
			return "";
		}
		else {
			return $json;
		}
	}

	protected function updateDb($json) {
		if ($json === "") {
			return;
		}
		Schema::dropIfExists('camsexton_googleCal_events');

		Schema::create('camsexton_googleCal_sync'), function($table) {
			$table->engine = 'InnoDB';
			$table->string('nextSyncToken')->primary();
			$table->string('timeZone');
			$table->dateTime('lastUpdated');
			$table->string('calendarName');
			$table->string('calendarID');
		}


		Schema::create('camsexton_googleCal_events', function($table) {

            $table->engine = 'InnoDB';
			$table->string('eventID')->primary();
            $table->string('title')->nullable();
            $table->dateTime('datetime')->nullable();
            $table->string('venue')->nullable();
            $table->text('description')->nullable();
		});


		$timeZone_default = $this->checkField($json['timeZone'], 'UTC');

		foreach ($json['items'] as $number => $item) {

			if ($item['status'] === 'cancelled') {
				Db::delete('DELETE FROM camsexton_googleCal_events WHERE eventID = ?', [$item['id']]);
			} elseif ($item['status'] === 'confirmed') {
				$title = $this->checkField($item, 'summary');
				//$dateTime = $this->checkField($item['start'], ['dateTime']]);
				//$timeZone = $this->checkField($item['start']['timeZone']);
				$venue = $this->checkField($item, 'location');
				$description = $this->checkField($item, 'description');
			}

			Db::insert('INSERT OR REPLACE INTO camsexton_googleCal_events (id, title,venue,description) VALUES ((SELECT id FROM camsexton_googleCal_events WHERE eventID = ?),?,?, ?, ?)', [$eventID, $title, $venue, $description]);
		}

		
	}

	 protected function checkField($array, $field, $emptyVal = "") {
		 if (isset($array[$field])) {
			 return $array[$field];
		 }
		 else {
			 return $emptyVal;
		 }

	 }
/*
	protected function noUpcomingEvents() {
			$noEvents = array();

			array_push($noEvents, array(
			"gigTitle"=>"No upcoming events!",
			"venue"=>"",
			"date_time"=>"",
			"desc"=>"Please check back here soon for new announcements."));

			file_put_contents('php://stderr', print_r("\n\n\n noUpcomingEvents fired \n\n\n", TRUE));
			return $noEvents;
	}
	
	// Create an array containing the calendar event details.
	protected function formatCalEvents($calendar) {
		$schedule = array();
		
		if ($calendar === "" ) {
			return $this->noUpcomingEvents();
		} else {
			foreach ($calendar as $number => $item) {

				// format and add the date and time
				$d = new DateTime($item['start']['dateTime']);
				$date_time = $d->format('D M d') . ' at ' . $d->format('g:ia');

				// if a description is included, add it as well
				if (isset($item['description'])) {
					$desc = $item['description'];
				} else {
					$desc = '';
				};

				// if a location is included, add it as well
				if (isset($item['location'])) {
				$venue = $item['location'];
				} else {
					$venue = '';
				};

				// push all details into array
				array_push($schedule, array(
					"gigTitle"=>$item['summary'],
					"venue"=>$venue,
					"date_time"=>$date_time,
					"desc"=>$desc));
			};
			// return schedule list
			return $schedule;
		}
		// not entirely necessary line of code
		return $this->noUpcomingEvents();
	}
 */
}
