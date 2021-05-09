<?php

namespace App\Services\WeatherProviders\OpenWeather\Http;

use GuzzleHttp\Client;

class HttpClient
{
    /**
     * @var Client
     */
    public $apiClient;

    private const TIMEOUT = 20;

    /**
     * Instantiate client with some default settings, such as timeout
     */
    public function __construct()
    {
        $this->apiClient = new Client([
            'timeout' => self::TIMEOUT
        ]);
    }
}
