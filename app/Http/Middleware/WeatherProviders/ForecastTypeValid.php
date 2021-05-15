<?php

namespace App\Http\Middleware\WeatherProvider;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

/**
 * Validate the type of request forecast the use has selected is valid
 */
class ForecastTypeValid
{
    /**
     * @param Request $request
     */
    public function handle(Request $request)
    {
        $forecastType = $request->get('forecast-type');
        $validTypes = Config::get('open-weather');
    }
}
