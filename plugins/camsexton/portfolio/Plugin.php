<?php namespace CamSexton\Portfolio;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
		return [
			'CamSexton\Portfolio\Components\PortfolioGallery' => 'portfoliogallery'
		];
    }

    public function registerSettings()
    {
    }
}
