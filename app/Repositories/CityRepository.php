<?php

namespace App\Repositories;

use App\Models\City;
use Illuminate\Http\Request;

class CityRepository implements CityRepositoryInterface
{
    public function getAll()
    {
        return City::query()->orderBy('id', 'desc')->get();
    }

    public function getOrFail(int $id)
    {
        return City::findOrFail($id);
    }

    public function store(Request $request)
    {
        $city = new City();

        $city->name         = $request->name;
        $city->country_code = $request->country_code;
        $city->user_id      = \Auth::user()->id;

        $city->save();

        return $city;
    }
}