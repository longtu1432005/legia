<?php namespace Ntn\Configuration;

use Backend\Classes\ReportWidgetBase;
use Ntn\Configuration\Models\Configuration;

class ConfigurationWidget extends ReportWidgetBase{

    public function render()
    {
        $configs = Configuration::all()->count();

        return $this->makePartial('configs', [ 'configs' => $configs ]);
    }
}