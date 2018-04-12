<?php
	require_once __DIR__ . '/../TwigLoader.php';
	require_once __DIR__ . '/../cts-schedule.php';

	$schedule = formatCalEvents(getCal());

	$pageData = array("navlinks"=>$navlinks,"schedule"=>$schedule);

	echo $twig->render('schedule.html.twig', $pageData);

?>
