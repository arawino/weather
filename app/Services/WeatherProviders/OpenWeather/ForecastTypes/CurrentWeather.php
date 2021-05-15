<?php

namespace App\Services\WeatherProviders\OpenWeather\ForecastTypes;

use App\Models\Weather;
use App\Services\WeatherProviders\ForecastType;
use App\Services\WeatherProviders\OpenWeather\Exceptions\InvalidCityException;
use App\Services\WeatherProviders\OpenWeather\Http\HttpClient;
use Exception;

class CurrentWeather implements ForecastType
{
    /**
     * @var HttpClient
     */
    private HttpClient $client;

    /**
     * @param HttpClient $client
     */
    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * @inheritDoc
     */
    public function sendRequest(string $requestString): string
    {
        $url = $this->client->config["global"]["uri"];
        $apiKey = $this->client->getApiKey();
        $endpoint = sprintf('%s?q=%s,uk&appid=%s', $url, $requestString, $apiKey);

        try {
            $requestCurrent = $this->client->apiClient->request('GET', $endpoint, ['headers' => ['Accept' => '*/*']]);
            $response = $requestCurrent->getBody()->getContents();
        } catch (Exception $e) {
            throw new InvalidCityException($e->getMessage(), $e->getRequest(), $e->getResponse());
        }

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
