<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CountryCreateRequest;
use App\Models\Country;
use App\Traits\Searchable;
use Illuminate\Http\Request;

class ApiCountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use Searchable;
    public function index(Request $request)
    {
        $query = Country::query();
        $this->search($query, ['name']);
        $country = $query->paginate(20);
        return $country;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(CountryCreateRequest $request)
    {
        $country = Country::create($request->all());
        return $request->input();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $country = Country::findOrFail($id);
        $country->update($request->all());
        return $request->input();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $country = Country::destroy($id);
        if ($country) {
            return 'Record Delete';
        } else {
            return 'Record Not Found';
        }
    }
}
