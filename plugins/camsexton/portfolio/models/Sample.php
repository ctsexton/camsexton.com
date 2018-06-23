<?php namespace CamSexton\Portfolio\Models;

use Model;

/**
 * Model
 */
class Sample extends Model
{
    use \October\Rain\Database\Traits\Validation;
	use \October\Rain\Database\Traits\Sortable;
    
    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'camsexton_portfolio_items';
	public $attachOne = [
        'sample_pic' => 'System\Models\File'
    ];
}
