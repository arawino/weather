<?php

namespace App\Services\WeatherProviders\OpenWeather\Exceptions;

use GuzzleHttp\Exception\ClientException;

class InvalidCityException extends ClientException {}
