<?php

namespace App\Http\Controllers;

use App\Services\WeatherProviders\ForecastRequestFactory;
use App\Services\WeatherProviders\WeatherService;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request, ForecastRequestFactory $requestTypeFactory)
    {
        $weatherService = new WeatherService($requestTypeFactory);

        $data = $weatherService->getData(
            'OpenWeather',
            'current',//$request->get('forecast_type'),
            'London'//$request->get('city')
        );

        return view('index')->with('data', $data);
    }
}
