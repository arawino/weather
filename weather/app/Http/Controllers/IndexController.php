<?php

namespace App\Http\Controllers;

use App\Services\WeatherProviders\WeatherService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * @var WeatherService
     */
    private $weatherService;

    private const CURRENT_FORECAST = 'current';
    private const OPEN_WEATHER_PROVIDER = 'OpenWeather';

    /**
     * @param WeatherService $weatherService
     */
    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    /**
     * @param Request $request
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $data = $this->weatherService->getData(self::OPEN_WEATHER_PROVIDER, self::CURRENT_FORECAST);

        return view('index')->with('data', $data);
    }

    /**
     * Return result for a given city
     *
     * @param Request $request
     * @return Application|Factory|View
     */
    public function currentWeatherResult(Request $request)
    {
        $this->validate($request, ['city' => 'required']);

        $data = $this->weatherService->getData(
            self::OPEN_WEATHER_PROVIDER,
            self::CURRENT_FORECAST,
            $request->get('city')
        );

        return view('result')->with('data', $data);
    }
}
