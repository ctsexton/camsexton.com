<?php
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
<!DOCTYPE html>

<html lang="en">
	<head>
		<link rel="stylesheet" href="reset.css">
		<link rel="stylesheet" href="styles.css">
		<meta name="viewport" content="width=device-width">
		<link href="https://fonts.googleapis.com/css?family=Mr+Dafoe|Libre+Baskerville" rel="stylesheet">
	</head>
	<header>
		<div class="cts-navbar">
			<a href="index.html" id="cts-home-button">Lillian Albazi Quintet</a>
			<ul class="cts-navbar__main-list">
				<li><a href="about.html">about</a></li>
				<li><a href="schedule.php">schedule</a></li>
				<li><a href="press.html">press</a></li>
				<li><a href="contact.html">contact</a></li>
			</ul>
			<div class="cts-page-title">Upcoming Performances:</div>
		</div>
	</header>
	<body>
		<div class="cts-main-content">
			<div id="php-schedule">
				<ul>
					<?php formatCalEvents($cal); ?>
				</ul>	
			</div>
		</div>
	</body>
</html>
