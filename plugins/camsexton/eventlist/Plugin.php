<?php namespace CamSexton\EventList;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
		return [
			'CamSexton\EventList\Components\EventList' => 'eventlist',
			'CamSexton\EventList\Components\DisplayEvents' => 'displayevents',
		];
    }

    public function registerSettings()
    {
    }
}
