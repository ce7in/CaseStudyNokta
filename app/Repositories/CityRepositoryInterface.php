<?php

namespace App\Repositories;

use App\Models\City;
use Illuminate\Http\Request;

interface CityRepositoryInterface
{
    public function getAll();

    public function getOrFail(int $id);

    public function store(Request $request);
}