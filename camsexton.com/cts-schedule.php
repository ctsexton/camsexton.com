<?php
	require_once __DIR__ . '/vendor/autoload.php';
	
	// set env variables from .env file
	$dotenv = new Dotenv\Dotenv(__DIR__);
	$dotenv->load();

	function getCal() {
		// load env variables
		$API_KEY = getenv("GCAL_API_KEY");
		$calendarID = getenv("GCAL_ID");
		$timeZone = getenv("GCAL_TIMEZONE");
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

		// GET request URL and convert JSON string to PHP object
		$cal = json_decode(file_get_contents($requestURL));
		return $cal->items;	
	};

	
	// Create an html list containing the calendar event details.
	function formatCalEvents($calendar) {
		$schedule = array();
		foreach ($calendar as $item) {

			// format and add the date and time
			$d = new DateTime($item->start->dateTime);
			$date_time = $d->format('D M d') . ' at ' . $d->format('g:ia');

			// if a description is included, add it as well
			if (property_exists($item, 'description')) {
				$desc = $item->description;
			} else {
				$desc = '';
			};

			array_push($schedule, array(
				"gigTitle"=>$item->summary,
				"venue"=>$item->location,
				"date_time"=>$date_time,
				"desc"=>$desc));
		};
		return $schedule;
	};

	function renderSchedule($schedule) {
		foreach ($schedule as $item) {
			// output html list
			echo 
			'<li>' . 
			'<div class="php-gCal__title">' . $item->gigTitle . '</div>' . 
			'<div class="php-gCal__details">' . 
				$item->date_time . '</br>' .
				$item->venue . 
				'</br>' . 
				$item->desc . 
			'</div>' . 
			'</li>';

		};
	};


?>
