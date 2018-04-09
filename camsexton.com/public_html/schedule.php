<?php
require_once __DIR__ . '/../TwigLoader.php';

echo $twig->render('schedule.html.twig', $navlinks);

?>
