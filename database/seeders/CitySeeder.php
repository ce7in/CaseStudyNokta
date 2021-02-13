<?php

namespace Database\Seeders;

use App\Jobs\GetCurrentWeatherData;
use App\Jobs\GetForecastWeatherData;
use App\Models\City;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run()
    {
        $user = User::query()->inRandomOrder()->first();
        $cities = [
            'Ankara',
            'İzmir',
            'İstanbul',
            'Kocaeli',
            'Manisa',
            'Kayseri',
            'Yozgat',
            'Aydın',
            'Kütahya',
            'Uşak',
            'Zonguldak',
            'Adana',
            'Bursa',
            'Balıkesir',
            'Bilecik',
            'Bartın'
        ];

        foreach ($cities as $city) {
            City::create([
                             'user_id'      => $user->id,
                             'country_code' => 'TR',
                             'name'         => $city
                         ]);
        }

        GetCurrentWeatherData::dispatch();
        GetForecastWeatherData::dispatch();
    }
}
