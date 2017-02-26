<?php

/*
 * Function for debug
 */
function pr($data = null, $die = true)
{
    $trace = debug_backtrace();
    $caller = array_shift($trace);
    echo '<pre>';
    echo "called by [" . $caller['file'] . "] line: " . $caller['line'] . "\n";
    var_dump($data);
    echo '</pre>';
    if ($die) {
        exit;
    }
}

class MyHelper {

    public static function formatCurrency($number, $showCurrency = true)
    {
        $numberFormatted = number_format($number, 0, ',', '.');
        if ($showCurrency) {
            $currency = \Ntn\Configuration\Models\Configuration::getValueByKey('CURRENCY');
            return $numberFormatted . ' ' . $currency;
        }

        return $numberFormatted;
    }
}