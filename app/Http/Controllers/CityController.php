<?php

namespace App\Http\Controllers;

use App\Jobs\GetCurrentWeatherData;
use App\Jobs\GetForecastWeatherData;
use App\Models\City;
use App\Repositories\CityRepositoryInterface;
use Illuminate\Http\Request;

class CityController extends Controller
{
    private $repository;

    public function __construct(CityRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        //Assign the main data
        $data = [
            'favicon' => null,
            'title'   => __('app.homeTitle'),
            'meta'    => [
                'keywords'    => __('app.homeMetaKeywords'),
                'description' => __('app.homeMetaDescription')
            ],
        ];

        //Get all cities from db
        $cities = $this->repository->getAll();

        return view('pages.index')
            ->with($data)
            ->with('cities', $cities);
    }

    public function show(int $id)
    {
        $city = $this->repository->getOrFail($id);

        //Assign the main data
        $data = [
            'favicon' => null,
            'title'   => $city->name,
            'meta'    => [
                'keywords'    => $city->name . ', weather forecast, hourly weather forecast',
                'description' => $city->name
            ],
        ];

        return view('pages.show')
            ->with($data)
            ->with('city', $city);
    }

    //Dashboard methods
    public function adminIndex()
    {
        //Get all cities from db
        $cities = $this->repository->getAll();

        return view('dashboard.index')
            ->with('cities', $cities);
    }

    public function create()
    {
        return view('dashboard.create');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
                                            'country_code' => 'required|max:2',
                                            'name'         => 'required|max:255|unique:cities',
                                        ]);

        $city = $this->repository->store($request);

        GetCurrentWeatherData::dispatch($city);
        GetForecastWeatherData::dispatch($city);

        return redirect()->route('dashboard');
    }
}
