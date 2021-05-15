<?php

namespace App\Http\Controllers;

use App\Http\Requests\OpenWeatherFormRequest;
use App\Services\WeatherProviders\OpenWeather\Exceptions\InvalidCityException;
use App\Services\WeatherProviders\WeatherService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IndexController extends Controller
{
    /**
     * @var WeatherService
     */
    private WeatherService $weatherService;

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
        $data = $this->weatherService->getData(WeatherService::OPEN_WEATHER_PROVIDER);

        return view('index')->with('data', $data);
    }

    /**
     * Return result for a given city, logs exception for any invalid city request
     *
     * @param OpenWeatherFormRequest $request
     * @return mixed
     */
    public function currentWeatherResult(OpenWeatherFormRequest $request)
    {
        try {
            $data = $this->weatherService->getData(
                WeatherService::OPEN_WEATHER_PROVIDER,
                WeatherService::CURRENT_FORECAST,
                $request->get('city')
            );
        } catch (InvalidCityException $e) {
            Log::info($e->getMessage());
            return back()->withError( 'Invalid city: Please enter valid UK city')->withInput();
        }

        return view('result')->with('data', $data);
    }
}
