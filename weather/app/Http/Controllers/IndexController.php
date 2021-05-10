<?php

namespace App\Http\Controllers;

use App\Services\WeatherProviders\OpenWeather\Exceptions\InvalidCityException;
use App\Services\WeatherProviders\WeatherService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class IndexController extends Controller
{
    /**
     * @var WeatherService
     */
    private $weatherService;

    private const CURRENT_FORECAST = 'current';
    private const OPEN_WEATHER_PROVIDER = 'OpenWeather';
    private const CURRENT_FORECAST_CACHE_LIFESPAN = 1800; // 30 minute

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
     * Return result for a given city, we are caching the weather data for 30 minutes for every city and forecast type
     * so an not to make frequent api request assuming weather cannot massively change within a 30 minute period.
     *
     * @param Request $request
     * @return mixed
     * @throws ValidationException
     */
    public function currentWeatherResult(Request $request)
    {
        $this->validate($request, ['city' => 'required']);
        $cacheKey = sprintf('%s_%s_uk', self::CURRENT_FORECAST, $request->get('city'));

        try {
            if (!Cache::get($cacheKey)) {
                $data = $this->weatherService->getData(
                    self::OPEN_WEATHER_PROVIDER,
                    self::CURRENT_FORECAST,
                    $request->get('city')
                );

                Cache::put($cacheKey, $data, now()->addSeconds(self::CURRENT_FORECAST_CACHE_LIFESPAN));
            } else {
                $data = Cache::get($cacheKey);
            }
        } catch (InvalidCityException $e) {
            return back()->withError( 'Invalid city: Please enter valid UK city')->withInput();
        }

        return view('result')->with('data', $data);
    }

}
