<?php namespace Feegleweb\OctoshopLite\Models;

use Illuminate\Support\Facades\Log;
use Model;
use Carbon\Carbon;

/**
 * Product Model
 */
class Product extends Model
{
    use \October\Rain\Database\Traits\Validation;

    /**
     * @var string The database table used by the model.
     */
    public $table = 'feegleweb_octoshop_products';

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
        'title' => ['required', 'between:4,255'],
        'slug' => [
            'required',
            'alpha_dash',
            'between:1,255',
        ],
        'price' => ['numeric', 'max:99999999.99'],
        'discount' => ['numeric', 'max:100'],
    ];

    /**
     * @var array Attributes to mutate as dates
     */
    protected $dates = ['available_at', 'created_at', 'updated_at'];

    /**
     * @var array Relations
     */
    public $belongsToMany = [
        'categories' => [
            'Feegleweb\OctoshopLite\Models\Category',
            'table' => 'feegleweb_octoshop_prod_cat',
        ],
        'sizes' => [
            'Feegleweb\OctoshopLite\Models\Size',
            'table' => 'feegleweb_octoshop_prod_variants',
        ],
        'colors' => [
            'Feegleweb\OctoshopLite\Models\Color',
            'table' => 'feegleweb_octoshop_prod_variants',
        ],
    ];


    /**
     * @var array Image attachments
     */
    public $attachMany = [
        'images' => ['System\Models\File']
    ];

    public function scopeEnabled($query)
    {
        return $query->where('is_enabled', true);
    }

    public function scopeAvailable($query)
    {
        return $this->enabled();
    }

    /**
     * Allows filtering for specifc categories
     *
     * @param  Illuminate\Query\Builder  $query      QueryBuilder
     * @param  array                     $categories List of category ids
     * @return Illuminate\Query\Builder              QueryBuilder
     */
    public function scopeFilterCategories($query, $categories)
    {
        return $query->whereHas('categories', function($q) use ($categories) {
            $q->whereIn('id', $categories);
        });
    }

    public function inStock()
    {
        if (!$this->is_stockable) {
            return true;
        }

        return $this->stock > 0;
    }

    public function outOfStock()
    {
        return !$this->inStock();
    }

    public function getSquareThumb($size, $image)
    {
        return $image->getThumb($size, $size, ['mode' => 'crop']);
    }

    public function setUrl($pageName, $controller)
    {
        $params = [
            'id' => $this->id,
            'slug' => $this->slug,
        ];

        return $this->url = $controller->pageUrl($pageName, $params);
    }

    public function getImageAttribute()
    {
        if (count($this->images)) {
            $imgSrc = $this->images[0]->getThumb(50, 50, ['mode' => 'crop']);
            return '<img src="' . asset($imgSrc) . '">';

        } else {
            return '<i class="icon-file-image-o" style="font-size: 25px"></i>';
        }
    }

    public function getPrice()
    {
        $price = $this->price;
        if ($this->discount > 0) {
            $price -= ($price * $this->discount)/100;
        }

        return $price;
    }

    public function formatOriginalPrice()
    {
        return \MyHelper::formatCurrency($this->price);
    }

    public function formatPrice()
    {
        return \MyHelper::formatCurrency($this->getPrice());
    }
}
