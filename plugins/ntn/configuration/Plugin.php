<?php namespace Ntn\Configuration;

use Backend;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use System\Classes\PluginBase;
use System\Classes\SettingsManager;

/**
 * configuration Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'ntn.configuration::lang.plugin.name',
            'description' => 'ntn.configuration::lang.plugin.description',
            'author'      => 'NTN',
            'icon'        => 'icon-cog'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return []; // Remove this line to activate

        return [
            'Ntn\Configuration\Components\MyComponent' => 'myComponent',
        ];
    }

    /**
     * Registers any back-end permissions used by this plugin.
     *
     * @return array
     */
    public function registerPermissions()
    {
        return [
            'ntn.configuration.access_settings' => [
                'tab' => 'Configuration',
                'label' => 'Configuration management'
            ],
        ];
    }

    /**
     * Registers menu on Settings.
     *
     * @return array
     */
    public function registerSettings()
    {
        return [
            'configuration' => [
                'label'       => 'ntn.configuration::lang.plugin.name',
                'description' => 'ntn.configuration::lang.plugin.description',
                'icon'        => 'icon-cog',
                'permissions' => ['ntn.configuration.access_settings'],
                'url'         => Backend::url('ntn/configuration/configuration'),
                'category'    => SettingsManager::CATEGORY_SYSTEM
            ]
        ];
    }

    public function registerNavigation()
    {
        return [
           
                'sideMenu' => [
                    'new_post' => [
                        'label'       => 'New product',
                        'icon'        => 'icon-plus',
                        'url'         => Backend::url('feegleweb/octoshoplite/products/create'),
                        'permissions' => ['feegleweb.octoshop.access_products']
                    ],
                    'posts' => [
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
                    ]
                ]
            
        ];
    }

    public function registerReportWidgets()
    {
        return [
            'Ntn\Configuration\ConfigurationWidget' => [
                'label'     => 'Total Configuration',
                'context'   => 'dashboard'
            ]
        ];
    }



}
