<?php

namespace App\Services\WeatherProviders;

use App\Services\WeatherProviders\OpenWeather\Exceptions\InvalidForecastType;
use Illuminate\Support\Facades\App;

/**
 * Forecast type factory class, creating an instance of a given forecast type, e.g current weather or hourly, historical
 * e.t.c
 */
class ForecastRequestFactory
{
    private const CURRENT_WEATHER = 'CurrentWeather';

    /**
     * This will make it easy to create instances of different forecast types, e.g historical\hourly
     *
     * @param string $provide
     * @param string $type
     * @return mixed
     */
    public function create(string $provide, string $type): ForecastType
    {
        $path = sprintf('App\Services\WeatherProviders\\%s\\ForecastTypes\\%s', $provide, $this->buildClassName($type));

        return App::make($path);
    }

    /**
     * Checks if the return type is of valid, throws an exception if the select forecast is invalid
     *
     * @param string $type
     * @return string
     * @throws InvalidForecastType
     */
    public function buildClassName(string $type): string
    {
        $name = '';

        try {
            switch ($type) {
                case 'current':
                    $name = self::CURRENT_WEATHER;
            }

            return $name;
        } catch (\Exception $e) {
            throw new InvalidForecastType();
        }
    }
}
