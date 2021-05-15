<?php

namespace App\Console\Commands;

use App\Models\Weather;
use App\Services\WeatherProviders\OpenWeather\Exceptions\InvalidCityException;
use App\Services\WeatherProviders\WeatherService;
use Illuminate\Console\Command;

class CurrentForecast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'current:forecast {city}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get current weather - Open Weather Maps';
    /**
     * @var WeatherService
     */
    private WeatherService $service;

    /**
     * Create a new command instance.
     *
     * @param WeatherService $service
     */
    public function __construct(WeatherService $service)
    {
        $this->service = $service;
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        try {
            $data = $this->service->getData(
                WeatherService::OPEN_WEATHER_PROVIDER,
                WeatherService::CURRENT_FORECAST,
                $this->argument('city')
            );
            $headers = [sprintf('Current %s Forecast', $data->getCity()), 'Measurement'];

            $data = [
                ['Condition', $data->getCondition()],
                ['Temperature', $data->getTemperature() . Weather::TEMP_SYMBOL],
                ['Min Temperature', $data->getMinTemperature() . Weather::TEMP_SYMBOL],
                ['Max Temperature', $data->getMaxTemperature() . Weather::TEMP_SYMBOL],
                ['Feels like',$data->getFeelsLike() . Weather::TEMP_SYMBOL],
                ['Wind', $data->getWindSpeed() . Weather::WIND_IN_KPH],
                [ 'Humidity', $data->getHumidity() . Weather::HUMIDITY_SYMBOL],
                [
                    'Rain volume', $data->getRainVolume()
                    ? sprintf('%s%s',$data->getRainVolume(), Weather::RAIN_SYMBOL_IN_MM)
                    : null
                ]
            ];

            $this->table($headers, $data);
        } catch (InvalidCityException $e) {
            $this->info('Please enter a valid UK city');
        }
    }
}
