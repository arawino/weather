<?php

namespace App\Services\WeatherProviders\OpenWeather\ForecastTypes;

use App\Models\Weather;
use App\Services\WeatherProviders\ForecastType;
use App\Services\WeatherProviders\OpenWeather\Http\HttpClient;
use Illuminate\Support\Facades\Config;

class CurrentWeather implements ForecastType
{
    /**
     * @var HttpClient
     */
    private $client;

    /**
     * @var mixed
     */
    private $config;

    /**
     * @param HttpClient $client
     */
    public function __construct(HttpClient $client)
    {
        $this->client = $client;
        $this->config = Config::get('open-weather');

    }

    /**
     * @inheritDoc
     */
    public function sendRequest(string $requestString): string
    {
        $url = $this->config["global"]["uri"];
        $apiKey = $this->config["global"]["api_key"];
        $endpoint = sprintf('%s?q=%s&appid=%s', $url, $requestString, $apiKey);

        $requestCurrent = $this->client->apiClient->request('GET', $endpoint, ['headers' => ['Accept' => '*/*']]);

        $response = $requestCurrent->getBody()->getContents();
        return $response;
    }

    /**
     * @inheritDoc
     */
    public function parseResponse(string $jsonResponse): ?Weather
    {
        $response  = json_decode($jsonResponse);

        $weather = new Weather();
        $weather->setCity($response->name);
        $weather->setTemperature($response->main->temp);
        $weather->setMinTemperature($response->main->temp_min);
        $weather->setMaxTemperature($response->main->temp_max);
        $weather->setFeelsLike($response->main->feels_like);
        $weather->setHumidity($response->main->humidity);
        $weather->setWindSpeed($response->wind->speed);
        $weather->setCondition($response->weather[0]->description);

        if (isset($response->rain)) {
            $rain = json_decode(json_encode($response->rain), true);
            $weather->setRainVolume($rain['1h'] .' mm');
        }

        return $weather;
    }
}
