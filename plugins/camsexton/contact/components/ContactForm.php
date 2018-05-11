<?php namespace CamSexton\Contact\Components;

use Cms\Classes\ComponentBase;
use Input;
use Mail;
use Validator;
use ValidationException;

class ContactForm extends ComponentBase

{
	public function componentDetails() {
		return [
			'name' => 'Contact Form',
			'description' => 'Simple contact form'
		];
	}

	public function onSend() {
		
		// place post data from form into data variables
		$data = post();
		
		// Set validation rules
		$rules = [
				'name' => 'required',
				'email' => 'required|email'
			];

		// Validate form inputs
		$validation = Validator::make($data, $rules);

		if ($validation->fails()) {
			// Render invalid field messages on page
			throw new ValidationException($validation);
		} else {
			
			$vars = ['name' => Input::get('name'), 'email' => Input::get('email'), 'content' => Input::get('content')];

			// Send email to me
			Mail::send('camsexton.contact::mail.message', $vars, function($message) use ($vars) {

				$message->to('cameron.t.sexton@gmail.com', 'Admin Person');
				$message->subject('New contact form message from ' . $vars['name']);
			});

			// Send email copy to sender
			Mail::send('camsexton.contact::mail.message_copy', $vars, function($message) use ($vars) {

				$message->to($vars['email'], 'Cam Sexton');
				$message->subject('Thanks for your message');
			});

			// Display success message
			return ['#formContent' => $this->renderPartial('@formSuccess.htm', [
				'name' => Input::get('name')
			])];
		}
	}
}
