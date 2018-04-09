<?php
require_once __DIR__ . '/../TwigLoader.php';

echo $twig->render('home.html.twig', $navlinks);

?>
