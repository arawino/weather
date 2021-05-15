<?php

namespace App\Services\WeatherProviders;

use App\Models\Weather;
use Illuminate\Support\Facades\Cache;

/**
 * Format Api response and pass to the controller
 */
class WeatherService
{
    /**
     * @var ForecastRequestFactory
     */
    private ForecastRequestFactory $requestTypeFactory;

    private const CURRENT_FORECAST_CACHE_LIFESPAN = 1800; // 30 minute
    public const OPEN_WEATHER_PROVIDER = 'OpenWeather';
    public const CURRENT_FORECAST = 'current';

    /**
     * @param ForecastRequestFactory $requestTypeFactory
     */
    public function __construct(ForecastRequestFactory $requestTypeFactory)
    {
        $this->requestTypeFactory = $requestTypeFactory;
    }

    /**
     * Get weather data depending on a given type and weather provide, weather provide can be weather data from
     * a different API. We are caching the weather data for 30 minutes for every city and forecast type
     * so an not to make frequent api request assuming weather cannot massively change within a 30 minute period.
     *
     * @param string $provide
     * @param string $type
     * @param string $city
     * @return null|Weather
     */
    public function getData(string $provide, string $type = 'current', string $city = 'London'): ?Weather
    {
        $cacheKey = sprintf('%s_%s_uk', $type, $city);

        if (Cache::get($cacheKey)) {
           return Cache::get($cacheKey);
        }

        $weatherProvide = $this->requestTypeFactory->create($provide, $type);
        $response = $weatherProvide->sendRequest($city);
        $data = $weatherProvide->parseResponse($response);

        // get data and cache for 10 minutes if no cache exist
        Cache::put($cacheKey, $data, now()->addSeconds(self::CURRENT_FORECAST_CACHE_LIFESPAN));

        return $data;
    }
}
