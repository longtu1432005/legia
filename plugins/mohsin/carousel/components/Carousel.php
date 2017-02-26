<?php namespace Mohsin\Carousel\Components;

use Cms\Classes\ComponentBase;
use Mohsin\Carousel\Models\Carousel as CarouselModel;

class Carousel extends ComponentBase
{

    public function componentDetails()
    {
        return [
            'name'        => 'mohsin.carousel::lang.settings.name',
            'description' => 'mohsin.carousel::lang.settings.description'
        ];
    }

    public function defineProperties()
    {
        return [
            'id' => [
                'title'        => 'mohsin.carousel::lang.settings.name',
                'description'  => 'mohsin.carousel::lang.settings.choice',
                'type'         => 'dropdown'
            ],
            'height' => [
                'title'         => 'Height',
                'description'   => 'Height of slide',
                'type'          => 'string',
                'validationPattern' => '^[0-9]+$',
                'default'       => '400',
            ],
        ];
    }

    public function getidOptions()
    {
      return CarouselModel::select('id', 'name') -> orderBy('name') -> get() -> lists('name', 'id');
    }

    public function onRun()
    {
        $carousel = new CarouselModel;
        $this -> carousel = $this -> page['carousel'] = $carousel -> where('id', '=', $this -> property('id')) -> first();
        // Inject all slider properties to page.
        foreach ($this->getProperties() as $key => $value) {
            $this->page[$key] = $value;
        }
    }

}
