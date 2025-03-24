<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LocationController extends Controller
{
    /**
     * Get all the states of a country by its ID.
     *
     * @param string $countryId The ID of the country
     */
    function getStates(string $countryId): Response
    {

        $state = State::select(['id', 'name', 'country_id'])->where('country_id', $countryId)->get();
        return response($state);
    }
    /**
     * Get all the cities of a states by its ID.
     *
     * @param string $stateID The ID of the country
     */
    function getCities(string $stateId): Response
    {

        $cities = City::select(['id', 'name', 'state_id', 'country_id'])->where('state_id', $stateId)->get();
        return response($cities);
    }
}
