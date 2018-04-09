<?php
require_once __DIR__ . '/../TwigLoader.php';

echo $twig->render('about.html.twig', $navlinks);

?>
