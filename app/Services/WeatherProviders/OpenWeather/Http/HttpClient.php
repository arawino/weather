<?php

namespace App\Services\WeatherProviders\OpenWeather\Http;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;

class HttpClient
{
    /**
     * @var Client
     */
    public Client $apiClient;

    public $config;

    private const TIMEOUT = 20;

    /**
     * Instantiate client with some default settings, such as timeout
     */
    public function __construct()
    {
        $this->apiClient = new Client([
            'timeout' => self::TIMEOUT
        ]);

        $this->config = Config::get('open-weather');
    }

    /**
     * Returns api_key based on the environment
     * @return string
     */
    public function getApiKey(): string
    {
        if(app()->get('env') == 'production'){
            return $this->config["global"]["production_api_key"];
        }

        return $this->config["global"]["testing_api_key"];
    }
}
