<?php namespace CamSexton\EventList;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
		return [
			'CamSexton\EventList\Components\EventList' => 'eventlist',
		];
    }

    public function registerSettings()
    {
    }
}
