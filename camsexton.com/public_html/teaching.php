<?php
require_once __DIR__ . '/../TwigLoader.php';
$pageData = array("navlinks"=>$navlinks);

echo $twig->render('teaching.html.twig', $pageData);


?>
