<?php namespace Feegleweb\OctoshopLite\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Orders Back-end Controller
 */
class Orders extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController',
        'Backend.Behaviors.RelationController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    public $bodyClass = 'compact-container';

    protected $assetsPath = '/plugins/feegleweb/octoshoplite/assets';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Feegleweb.OctoshopLite', 'shop', 'orders');

        $this->addCss($this->assetsPath.'/css/modal-form.css');
        $this->addJs($this->assetsPath.'/js/product-form.js');
    }
}
