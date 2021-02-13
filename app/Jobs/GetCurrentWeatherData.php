<?php

namespace App\Jobs;

use App\Models\City;
use App\Repositories\CityRepository;
use Ce7in\LaravelOpenweather\Facades\OpenWeather;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GetCurrentWeatherData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $repository;
    protected $city;

    public function __construct(?City $city = null)
    {
        $this->repository = new CityRepository();
        $this->city       = $city;
    }

    /**
     * Execute the job.
     * @return void
     */
    public function handle()
    {
        if ($this->city)
            $cities = [$this->city];
        else
            $cities = $this->repository->getAll();

        foreach ($cities as $city) {
            $response = OpenWeather::getCurrentWeatherByCityName($city->name . ', ' . $city->country_code);

            if ( ! $response)
                continue;

            $city->current_response   = json_encode($response);
            $city->current_updated_at = now();

            $city->save();
        }
    }
}
