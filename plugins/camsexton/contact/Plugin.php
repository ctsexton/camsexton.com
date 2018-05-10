<?php namespace CamSexton\Contact;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
		return [
			'CamSexton\Contact\Components\ContactForm' => 'contactform',
		];
    }

    public function registerSettings()
    {
    }

}
