<?php

namespace App\Models;

class Weather
{
    /**
     * @var string
     */
    private $city;

    /**
     * @var float
     */
    private $temperature;

    /**
     * @var
     */
    private $minTemperature;

    /**
     * @var
     */
    private $maxTemperature;

    /**
     * @var
     */
    private $windSpeed;

    /**
     * @var null|string
     */
    private $rainVolume;

    /**
     * @var
     */
    private $feelsLike;

    /**
     * @var string
     */
    private $humidity;

    /**
     * @var string
     */
    private $condition;

    /**
     * @param string $city
     */
    public function setCity(string $city): void{
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param float $temperature
     */
    public function setTemperature(float $temperature): void
    {
        $this->temperature = $temperature;
    }

    /**
     * @return float
     */
    public function getTemperature(): float
    {
        return $this->temperature;
    }

    /**
     * @param float $minTemperature
     */
    public function setMinTemperature(float $minTemperature): void
    {
        $this->minTemperature = $minTemperature;
    }

    /**
     * @return float
     */
    public function getMinTemperature(): float
    {
        return $this->minTemperature;
    }

    /**
     * @param float $maxTemperature
     */
    public function setMaxTemperature(float $maxTemperature): void
    {
        $this->maxTemperature = $maxTemperature;
    }

    /**
     * @return float
     */
    public function getMaxTemperature(): float
    {
        return $this->maxTemperature;
    }

    /**
     * @param string $wind
     */
    public function setWindSpeed(string $wind): void{
        $this->windSpeed = $wind;
    }

    /**
     * @return string
     */
    public function getWindSpeed(): string
    {
        return $this->windSpeed;
    }

    /**
     * @param null|string $rain
     */
    public function setRainVolume(?string $rain): void
    {
        $this->rainVolume = $rain;
    }

    /**
     * @return null|string
     */
    public function getRainVolume(): ?string{
        return $this->rainVolume;
    }

    /**
     * @param float $feelLike
     */
    public function setFeelsLike(float $feelLike): void
    {
        $this->feelsLike = $feelLike;
    }

    /**
     * @return float
     */
    public function getFeelsLike(): float
    {
        return $this->feelsLike;
    }

    /**
     * @param string $humidity
     */
    public function setHumidity(string $humidity): void
    {
        $this->humidity = $humidity;
    }

    /**
     * @return string
     */
    public function getHumidity(): string
    {
        return $this->humidity;
    }

    /**
     * @param string $condition
     */
    public function setCondition(string $condition): void
    {
        $this->condition = $condition;
    }

    /**
     * @return string
     */
    public function getCondition(): string
    {
        return $this->condition;
    }
}
