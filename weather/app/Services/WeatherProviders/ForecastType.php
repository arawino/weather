<?php

namespace App\Services\WeatherProviders;

use App\Models\Weather;

interface ForecastType
{
    /**
     * @param string $requestString
     * @return string
     */
    public function sendRequest(string $requestString): string;

    /**
     * @param string $jsonResponse
     * @return null|array
     */
    public function parseResponse(string $jsonResponse): ?Weather;
}
