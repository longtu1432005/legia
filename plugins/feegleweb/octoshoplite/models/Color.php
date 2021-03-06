<?php namespace Feegleweb\OctoshopLite\Models;

use Model;
use Carbon\Carbon;

/**
 * Product Model
 */
class Color extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'feegleweb_octoshop_colors';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules
     */
    protected $rules = [
        'name' => ['required', 'between:1,64'],
        'code' => ['required', 'between:1,64']
    ];

    /**
     * @var array Attributes to mutate as dates
     */
    protected $dates = ['created_at', 'updated_at'];
}
