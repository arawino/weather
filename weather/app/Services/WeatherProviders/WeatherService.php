<?php

namespace App\Services\WeatherProviders;

use App\Models\Weather;
use Illuminate\Support\Facades\Config;

/**
 * Format Api response and pass to the controller
 */
class WeatherService
{
    private $requestTypeFactory;

    /**
     * @param ForecastRequestFactory $requestTypeFactory
     */
    public function __construct(ForecastRequestFactory $requestTypeFactory)
    {
        $this->requestTypeFactory = $requestTypeFactory;
    }

    /**
     * Get weather data depending on a given type and weather provide, weather provide can be weather data from
     * a different API
     *
     * @param string $provide
     * @param string $type
     * @param string $city
     * @return null|Weather
     */
    public function getData(string $provide, string $type, string $city = 'London'): ?Weather
    {
        $weatherProvide = $this->requestTypeFactory->create($provide, $type);
        $response = $weatherProvide->sendRequest($city);

        return $weatherProvide->parseResponse($response);
    }
}
