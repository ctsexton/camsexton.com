<?php
	require __DIR__ . '/vendor/autoload.php';

	// set env variables from .env file
	$dotenv = new Dotenv\Dotenv(__DIR__);
	$dotenv->load();
	
	// load env variables
	$API_KEY = getenv("GCAL_API_KEY");
	$calendarID = getenv("GCAL_ID");
	$timeZone = getenv("GCAL_TIMEZONE");
	$today = new DateTime();
	$today->setTimezone(new DateTimeZone($timeZone));
	$timeMin = rawurlencode($today->format('Y-m-d') . 'T00:00:00' . $today->format('O'));

	// Construct GET request URL
	$requestURL = 'https://www.googleapis.com/calendar/v3/calendars/' . $calendarID . '%40group.calendar.google.com/events?orderBy=startTime&singleEvents=true&timeMin=' . $timeMin . '&key=' . $API_KEY;

	// GET request URL and convert JSON string to PHP object
	$cal = json_decode(file_get_contents($requestURL));
	$cal = $cal->items;	

	
	// Create an html list containing the calendar event details.
	function formatCalEvents($calendar) {
		foreach ($calendar as $item) {

			// add the event name
			$gigTitle = $item->summary;

			// add the location
			$venue = $item->location;

			// format and add the date and time
			$d = new DateTime($item->start->dateTime);
			$date_time = $d->format('D M d') . ' at ' . $d->format('g:ia');

			// if a description is included, add it as well
			if (property_exists($item, 'description')) {
				$desc = $item->description;
			} else {
				$desc = '';
			};

			// output html list
			echo 
			'<li>' . 
			'<div class="php-gCal__title">' . $gigTitle . '</div>' . 
			'<div class="php-gCal__details">' . 
				$date_time . '</br>' .
				$venue . 
				'</br>' . 
				$desc . 
			'</div>' . 
			'</li>';
			
		};
	};


?>
