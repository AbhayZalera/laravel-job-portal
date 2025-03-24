<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LocationController extends Controller
{
    //
    function getStateOfCountry(string $countryId): Response
    {
        // dd($countryId);
        $state = State::select(['id', 'name', 'country_id'])->where('country_id', $countryId)->get();
        return response($state);
    }

    function getCities(string $stateId): Response
    {

        $cities = City::select(['id', 'name', 'state_id', 'country_id'])->where('state_id', $stateId)->get();
        return response($cities);
    }
}
