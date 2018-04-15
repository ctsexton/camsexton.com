<?php
require_once __DIR__ . '/../TwigLoader.php';
$pageData = array("navlinks"=>$navlinks);

// Check that user submitted form
if (!isset($_POST['submit'])) {
	echo $twig->render('contact.html.twig', $pageData);
	error_log("Redirected to contact page", 0);
	exit();
}

$name = $_POST['name'];
$visitor_email = $_POST['email'];
$msg = $_POST['message'];

$email_from = "contact@camsexton.com";
$email_subject = "New Form Submission";
$email_body = "New message received from: $name.\n" .
	"Email address: $visitor_email\n" .
	"Message:\n$msg\n" .
	"---END MESSAGE---";
$to = "cameron.t.sexton@gmail.com";
$headers = "From: $email_from \r\n";

//send email!

// mail($to, $email_subject, $email_body, $headers);

$auto_resp_body = "Hi $name,\n\nThanks for getting in touch! Here's a copy of your message:\n\n\"$msg\"\n\nI'll get back to you ASAP!\n\nCam Sexton";

mail($visitor_email, "Your message has been received.", $auto_resp_body, "From: no-reply@camsexton.com \r\n");

// redirect
$pageData["success"] = "Thanks for your message $name! I'll get back to you ASAP.";
echo $twig->render('submitted.html.twig', $pageData);
?>
