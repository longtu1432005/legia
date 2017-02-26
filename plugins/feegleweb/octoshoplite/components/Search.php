<?php namespace Feegleweb\OctoshopLite\Components;

use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Feegleweb\OctoshopLite\Models\Category as ShopCategory;
use Feegleweb\OctoshopLite\Models\Product as ShopProduct;
use Illuminate\Support\Facades\Input;

class Search extends ComponentBase
{
    public $keyword;
    public $productPage;
    public $products;

    public function componentDetails()
    {
        return [
            'name'        => 'Product search',
            'description' => 'Display products from keyword for searching',
        ];
    }

    public function defineProperties()
    {
        return [
            'keyword' => [
                'title'       => 'Keyword',
                'description' => 'Keyword for searching.',
                'type'        => 'string',
                'default'     => '{{ :keyword }}'
            ],
            'basket' => [
                'title'       => 'Basket container element',
                'description' => 'CSS selector of the element to update when adding products to cart',
            ],
            'productPage' => [
                'title'       => 'Product Page',
                'description' => 'Name of the product page to use when generating links.',
                'type'        => 'dropdown',
                'default'     => 'shop/product',
                'group'       => 'Links',
            ],
        ];
    }

    public function getProductPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function onRun()
    {
        $this->prepareVars();

        $this->products = $this->page['products'] = $this->listProducts();
    }

    public function prepareVars()
    {
        $this->keyword = $this->page['keyword'] = Input::get('keyword');
        $this->basket = $this->page['basket'] = $this->property('basket');
        $this->productPage = $this->page['productPage'] = $this->property('productPage');
    }

    public function listProducts()
    {
        $products = ShopProduct::available()
            ->where('title', 'LIKE', '%' . $this->keyword . '%')
            ->with(['images' => function ($query) {
            $query->orderBy('sort_order', 'asc');
        }]);

        $products = $products->get()->each(function ($product) {

            $product->setUrl($this->productPage, $this->controller);
        });

        return $products;
    }

}
