<?php namespace Feegleweb\OctoshopLite\Models;

use Model;
use Carbon\Carbon;

/**
 * Product Model
 */
class Order extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'feegleweb_octoshop_orders';

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
        'username' => ['required', 'between:1,255'],
        'address' => ['required', 'between:1,255'],
        'phone' => ['required', 'between:1,255'],
        'product_id' => ['required', 'numeric'],
        'quantity' => ['required', 'numeric'],
    ];

    /**
     * @var array Attributes to mutate as dates
     */
    protected $dates = ['created_at', 'updated_at'];

    /**
     * @var array Relations
     */
    public $belongsTo = [
        'product' => [
            'Feegleweb\OctoshopLite\Models\Product',
            'table' => 'feegleweb_octoshop_prod_orders',
        ],
    ];

    public function getTotalAttribute()
    {
        return \MyHelper::formatCurrency($this->price * $this->quantity, false);
    }



}
