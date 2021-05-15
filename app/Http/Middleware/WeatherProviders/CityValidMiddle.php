<?php

namespace App\Http\Middleware\WeatherProvider;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class CityValidMiddle
{
    /**
     * Validate city is valid is valid before sending api request
     *
     * @param Request $request
     */
    public function handle(Request $request)
    {
        $city = $request->get('city');
        $validCities = Config::get('open-weather');
    }
}
