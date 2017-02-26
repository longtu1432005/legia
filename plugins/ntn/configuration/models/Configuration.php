<?php namespace Ntn\Configuration\Models;

use October\Rain\Database\Model;
use Illuminate\Support\Facades\Cache;

class Configuration extends Model
{
    // used for automatic validation using the defined rules.
    use \October\Rain\Database\Traits\Validation;

    public $table = 'configurations';

    // public $implement = ['System.Behaviors.SettingsModel'];
    public $settingsCode = 'Ntn_Configuration';
    public $settingsFields = 'fields.yaml';

    protected $guarded = ['*'];

    protected $rules = [
        'key'         => 'required|unique:configurations',
        'value' => 'required',
        'description' => 'required',
    ];

    /**
     * Get value of configuration by key
     * @param $key
     * @return string
     */
    public static function getValueByKey($key, $langCode = null)
    {
        $cacheKey = __FUNCTION__ . ':' . $key . '.' . $langCode;
        $result = Cache::tags('configurations')->get($cacheKey);

        if ($result == null) {
            if ($langCode) {
                $key .= '_' . $langCode;
            }
            $config = self::where('key', strtoupper($key))->first();
            if ($config) {

                $result = $config->value;
                Cache::tags('configurations')->forever($cacheKey, $result);
            }
        }
        return $result;
    }

}