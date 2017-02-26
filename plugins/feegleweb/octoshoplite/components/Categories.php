<?php namespace Feegleweb\OctoshopLite\Components;

use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use Feegleweb\OctoshopLite\Models\Category as ShopCategory;
use Feegleweb\OctoshopLite\Models\Product as ShopProduct;

class Categories extends ComponentBase
{

    /**
     * @var Collection A collection of categories to display
     */
    public $categories;

    /**
     * @var string Reference to the page name for linking to categories.
     */
    public $categoryPage;

    /**
     * @var string Reference to the current category slug.
     */
    public $currentCategorySlug;
    public $idCategory;

    public $category;

    public function componentDetails()
    {
        return [
            'name'        => 'Shop Category List',
            'description' => 'Displays a list of shop categories on the page.',
        ];
    }

    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'rainlab.blog::lang.settings.category_slug',
                'description' => 'rainlab.blog::lang.settings.category_slug_description',
                'default'     => '{{ :slug }}',
                'type'        => 'string'
            ],
            'id' => [
                'title'       => 'Id',
                'description' => 'Id category',
                'default'     => '{{ :id }}',
                'type'        => 'string'
            ],
            'categoryPage' => [
                'title'       => 'Category page',
                'description' => 'The name of the page to use when generating category links.',
                'type'        => 'dropdown',
                'default'     => 'shop/category',
                'group'       => 'Links',
            ],
        ];
    }

    public function getCategoryPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function onRun()
    {
        $this->prepareVars();
    }

    public function prepareVars()
    {
        $this->currentCategorySlug = $this->page['currentCategorySlug'] = $this->property('slug');
        $this->page['categoryBreadcrumb'] = ShopCategory::getParentCategoryNested($this->currentCategorySlug);
        $this->categoryPage = $this->page['categoryPage'] = $this->property('categoryPage');
        $this->categories = $this->page['categories'] = $this->listCategories();
    }

    public function listCategories()
    {
        $categories = ShopCategory::enabledAndVisible()->getNested();

        return $this->fillExtraData($categories);
    }

    public function fillExtraData($categories, $baseUrl = null, $rootCategory = true, $getTotalProduct = false)
    {
        return $categories->each(function ($c) use ($baseUrl, $rootCategory, $getTotalProduct) {

            $c->setUrl($this->categoryPage, $this->controller);
            if ($getTotalProduct) {
                $c->productCount = count($c->products);
            } else {
                $c->productCount = null;
            }

            if ($c->children) {
                $c->children = $this->fillExtraData($c->children, $c->url, false);
            }
        });
    }
}
