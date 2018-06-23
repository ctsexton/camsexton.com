<?php namespace CamSexton\Portfolio\Components;

use Cms\Classes\ComponentBase;
use CamSexton\Portfolio\Models\Sample;

class PortfolioGallery extends ComponentBase
{
	public function componentDetails() {
		return [
			'name' => 'Portfolio Gallery',
			'description' => 'Displays a list of portfolio samples'
		];
	}

	public $portfolio;

	public function onRun() {
		$this->portfolio = Sample::orderBy('sort_order', 'asc')->get();
	}
}
