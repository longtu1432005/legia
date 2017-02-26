<?php namespace Feegleweb\OctoshopLite;

use App;
use Backend;
use System\Classes\PluginBase;
use Illuminate\Foundation\AliasLoader;

/**
 * Shop Plugin Information File
 */
class Plugin extends PluginBase
{

    public function boot()
    {
        // Register service providers
        App::register('\Gloudemans\Shoppingcart\ShoppingcartServiceProvider');

        // Register facades
        $facade = AliasLoader::getInstance();
        $facade->alias('Cart', '\Gloudemans\Shoppingcart\Facades\Cart');
    }

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Octoshop Lite',
            'description' => 'Simplified version of Octoshop - the eCommerce plugin that lets you set up an online shop with ease.',
            'author'      => 'Dave Shoreman',
            'icon'        => 'icon-shopping-cart'
        ];
    }

    public function registerComponents()
    {
        return [
            'Feegleweb\OctoshopLite\Components\Basket' => 'shopBasket',
            'Feegleweb\OctoshopLite\Components\Categories' => 'shopCategories',
            'Feegleweb\OctoshopLite\Components\Product' => 'shopProduct',
            'Feegleweb\OctoshopLite\Components\ProductList' => 'shopProductList',
            'Feegleweb\OctoshopLite\Components\Search' => 'shopProductSearch',
        ];
    }

    public function registerNavigation()
    {
        return [
            'shop' => [
                'label'       => 'Product',
                'url'         => Backend::url('feegleweb/octoshoplite/products'),
                'icon'        => 'icon-shopping-cart',
                'permissions' => ['feegleweb.octoshop.*'],
                'order'       => 300,

                'sideMenu' => [
                    'newProduct' => [
                        'label'       => 'New product',
                        'icon'        => 'icon-plus',
                        'url'         => Backend::url('feegleweb/octoshoplite/products/create'),
                        'permissions' => ['feegleweb.octoshop.access_newProduct']
                    ],
                    'products' => [
                        'label'       => 'Products',
                        'icon'        => 'icon-copy',
                        'url'         => Backend::url('feegleweb/octoshoplite/products'),
                        'permissions' => ['feegleweb.octoshop.access_products']
                    ],
                    'categories' => [
                        'label'       => 'Categories',
                        'icon'        => 'icon-list-ul',
                        'url'         => Backend::url('feegleweb/octoshoplite/categories'),
                        'permissions' => ['feegleweb.octoshop.access_categories']
                    ],
                    'orders' => [
                        'label'       => 'Orders',
                        'icon'        => 'icon-cart-plus',
                        'url'         => Backend::url('feegleweb/octoshoplite/orders'),
                        'permissions' => ['feegleweb.octoshop.access_orders']
                    ],
                    'sizes' => [
                        'label'       => 'Sizes',
                        'icon'        => 'icon-child',
                        'url'         => Backend::url('feegleweb/octoshoplite/sizes'),
                        'permissions' => ['feegleweb.octoshop.access_sizes']
                    ],
                    'colors' => [
                        'label'       => 'Colors',
                        'icon'        => 'icon-list-ul',
                        'url'         => Backend::url('feegleweb/octoshoplite/colors'),
                        'permissions' => ['feegleweb.octoshop.access_colors']
                    ],
                ]
            ],
        ];
    }

    public function registerPermissions()
    {
        return [
            'feegleweb.octoshop.access_newProduct'   => ['label' => "New product"],
            'feegleweb.octoshop.access_products'   => ['label' => "Manage the shop's products"],
            'feegleweb.octoshop.access_categories' => ['label' => "Manage the shop categories"],
            'feegleweb.octoshop.access_orders' => ['label' => "Order management"],
            'feegleweb.octoshop.access_sizes' => ['label' => "Size management"],
            'feegleweb.octoshop.access_colors' => ['label' => "Color management"],
        ];
    }
}
