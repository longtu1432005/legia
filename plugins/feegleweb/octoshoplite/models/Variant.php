<?php namespace Feegleweb\OctoshopLite\Models;

use Model;

/**
 * Category Model
 */
class Variant extends Model
{
    use \October\Rain\Database\Traits\NestedTree;
    use \October\Rain\Database\Traits\Purgeable;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'feegleweb_octoshop_prod_variants';
    public $primaryKey = 'id';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = ['*'];

    /**
     * @var Relations
     */
    public $belongsToMany = [
        'products' => ['Feegleweb\OctoshopLite\Models\Product',
            'table' => 'feegleweb_octoshop_prod_cat',
            'order' => 'updated_at desc',
        ],
    ];
}
