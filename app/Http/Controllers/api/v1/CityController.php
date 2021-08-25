<?php

namespace App\Http\Controllers\api\v1;

use App\City;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::all();
        return compact('cities');
    }

}
