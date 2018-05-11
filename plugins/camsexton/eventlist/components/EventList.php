<?php namespace CamSexton\EventList\Components;

use Cms\Classes\ComponentBase;
use DateTime;
use DateTimeZone;

class EventList extends ComponentBase 

{
	public function componentDetails() {
		return [
			'name' => 'Event List',
			'description' => 'Displays events sourced from a public google calendar'
		];
	}

	public function onRun() {
		$this->page['schedule'] = $this->formatCalEvents($this->constructRequest());
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
			return $json['items'];
		}
	}


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

	// Create an html list containing the calendar event details.
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

}
