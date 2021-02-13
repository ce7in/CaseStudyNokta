<?php

namespace Ce7in\LaravelOpenweather;

use Illuminate\Support\Carbon;

class OpenWeather
{
    /**
     * @var array
     */
    public $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Performs an API request and returns the response.
     * Returns FALSE on failure.
     * @param string $url Request URI
     * @return string|bool
     */
    private function doRequest(string $url)
    {
        $response = @file_get_contents($url);
        return ( ! $response) ? FALSE : $response;
    }

    /**
     * Parses and returns an OpenWeather current weather API response as an array of formatted values.
     * Returns FALSE on failure.
     * @param string $response OpenWeather API response JSON.
     * @return array|bool
     */
    private function parseCurrentResponse(string $response)
    {
        $struct = json_decode($response, TRUE);

        if ( ! isset($struct['cod']) || $struct['cod'] != 200)
            return FALSE;

        return [
            'formats'   => [
                'lang'  => $this->config['api_lang'],
                'date'  => $this->config['format_date'],
                'day'   => $this->config['format_day'],
                'time'  => $this->config['format_time'],
                'units' => $this->config['format_units'],
            ],
            'datetime'  => [
                'timestamp'         => $struct['dt'],
                'timestamp_sunrise' => $struct['sys']['sunrise'],
                'timestamp_sunset'  => $struct['sys']['sunset'],
                'formatted_date'    => date($this->config['format_date'], $struct['dt']),
                'formatted_day'     => date($this->config['format_day'], $struct['dt']),
                'formatted_time'    => date($this->config['format_time'], $struct['dt']),
                'formatted_sunrise' => date($this->config['format_time'], $struct['sys']['sunrise']),
                'formatted_sunset'  => date($this->config['format_time'], $struct['sys']['sunset']),
            ],
            'location'  => [
                'id'        => (isset($struct['id'])) ? $struct['id'] : 0,
                'name'      => $struct['name'],
                'country'   => $struct['sys']['country'],
                'latitude'  => $struct['coord']['lat'],
                'longitude' => $struct['coord']['lon'],
            ],
            'condition' => [
                'name' => $struct['weather'][0]['main'],
                'desc' => $struct['weather'][0]['description'],
                'icon' => $this->config['api_endpoint_icons'] . $struct['weather'][0]['icon'] . '.png',
            ],
            'forecast'  => [
                'temp'     => round($struct['main']['temp']),
                'temp_min' => round($struct['main']['temp_min']),
                'temp_max' => round($struct['main']['temp_max']),
                'pressure' => round($struct['main']['pressure']),
                'humidity' => round($struct['main']['humidity']),
            ]
        ];
    }

    /**
     * Parses and returns an OpenWeather forecast weather API response as an array of formatted values.
     * Returns FALSE on failure.
     * @param string $response OpenWeather API response JSON.
     * @return array|bool
     */
    private function parseForecastResponse(string $response)
    {
        $struct = json_decode($response, TRUE);
        if ( ! isset($struct['cod']) || $struct['cod'] != 200) {
            return FALSE;
        }

        $forecast = [];
        foreach ($struct['list'] as $item) {
            $forecast[] = [
                'datetime'  => [
                    'timestamp'         => $item['dt'],
                    'timestamp_sunrise' => $struct['city']['sunrise'],
                    'timestamp_sunset'  => $struct['city']['sunset'],
                    'formatted_date'    => date($this->config['format_date'], $item['dt']),
                    'formatted_day'     => date($this->config['format_day'], $item['dt']),
                    'formatted_time'    => date($this->config['format_time'], $item['dt']),
                    'formatted_sunrise' => date($this->config['format_time'], $struct['city']['sunrise']),
                    'formatted_sunset'  => date($this->config['format_time'], $struct['city']['sunset']),
                ],
                'condition' => [
                    'name' => $item['weather'][0]['main'],
                    'desc' => $item['weather'][0]['description'],
                    'icon' => $this->config['api_endpoint_icons'] . $item['weather'][0]['icon'] . '.png',
                ],
                'forecast'  => [
                    'temp'     => round($item['main']['temp']),
                    'temp_min' => round($item['main']['temp_min']),
                    'temp_max' => round($item['main']['temp_max']),
                    'pressure' => round($item['main']['pressure']),
                    'humidity' => round($item['main']['humidity']),
                ]
            ];
        }
        return [
            'formats'  => [
                'lang'  => $this->config['api_lang'],
                'date'  => $this->config['format_date'],
                'day'   => $this->config['format_day'],
                'time'  => $this->config['format_time'],
                'units' => $this->config['format_units'],
            ],
            'location' => [
                'id'        => (isset($struct['city']['id'])) ? $struct['city']['id'] : 0,
                'name'      => $struct['city']['name'],
                'country'   => $struct['city']['country'],
                'latitude'  => $struct['city']['coord']['lat'],
                'longitude' => $struct['city']['coord']['lon'],
            ],
            'forecast' => $forecast
        ];
    }

    /**
     * Returns an OpenWeather API response for current weather.
     * Returns FALSE on failure.
     * @param array $params Array of request parameters.
     * @return array|bool
     */
    private function getCurrentWeather(array $params)
    {
        $params   = http_build_query($params);
        $request  = $this->config['api_endpoint_current'] . $params;
        $response = $this->doRequest($request);
        if ( ! $response) {
            return FALSE;
        }
        $response = $this->parseCurrentResponse($response);
        if ( ! $response) {
            return FALSE;
        }
        return $response;
    }

    /**
     * Returns an OpenWeather API response for forecast weather.
     * Returns FALSE on failure.
     * @param array $params Array of request parameters.
     * @return array|bool
     */
    private function getForecastWeather(array $params)
    {
        $params   = http_build_query($params);
        $request  = $this->config['api_endpoint_forecast'] . $params;
        $response = $this->doRequest($request);
        if ( ! $response) {
            return FALSE;
        }
        $response = $this->parseForecastResponse($response);
        if ( ! $response) {
            return FALSE;
        }
        return $response;
    }

    /**
     * Returns current weather by city name.
     * Returns FALSE on failure.
     * @param string $city City name (Boston) or city name and country code (Boston,US).
     * @param string $units Units of measurement (imperial, metric, kelvin)
     * @return array|bool
     */
    public function getCurrentWeatherByCityName(string $city, string $units = 'metric')
    {
        $this->config['format_units'] = $units;

        return $this->getCurrentWeather([
                                            'q'     => $city,
                                            'units' => $units,
                                            'lang'  => $this->config['api_lang'],
                                            'appid' => $this->config['api_key']
                                        ]);
    }

    /**
     * Returns forecast weather by city name.
     * Returns FALSE on failure.
     * @param string $city City name (Boston) or city name and country code (Boston,US).
     * @param string $units Units of measurement (imperial, metric, kelvin)
     * @return array|bool
     */
    public function getForecastWeatherByCityName(string $city, string $units = 'metric')
    {
        $this->config['format_units'] = $units;
        return $this->getForecastWeather([
                                             'q'     => $city,
                                             'units' => $units,
                                             'lang'  => $this->config['api_lang'],
                                             'appid' => $this->config['api_key']
                                         ]);
    }
}