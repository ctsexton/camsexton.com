<?php 
	require_once __DIR__ . '/vendor/autoload.php';

	$loader = new Twig_Loader_Filesystem(__DIR__ . '/templates');
	$twig = new Twig_Environment($loader, array(
		'cache' => false,
	));	

	$navlinks = array(
		'schedule' => 'schedule.php',
		'home' => 'index.php',
		'contact' => 'contact.php',
		'about' => 'about.php',
		'web' => 'web.php',
		'instruments' => 'instruments.php',
		'teaching' => 'https://www.musicteacher.com.au/cameron-sexton/drum-lessons/',
		'disco' => 'disco.php'
	);
?>
