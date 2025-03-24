<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Services\Notify;
use App\Traits\Searchable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\View\ViewException;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use Searchable;

    function __construct()
    {
        $this->middleware(['permission:city create|city update|city delete'])->only(['index']);
        $this->middleware(['permission:city create'])->only(['create', 'store']);
        $this->middleware(['permission:city update'])->only(['edit', 'update']);
        $this->middleware(['permission:city delete'])->only(['destroy']);
    }

    public function index(): View
    {
        //
        $query = City::query();
        $query->with(['country', 'state']);
        $this->search($query, ['name']);
        $cities = $query->paginate(20);
        return view('admin.Location.City.index', compact('cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $countries = Country::all();
        $states = State::all();
        return view('admin.Location.City.create', compact('countries', 'states'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // dd($request->all());
        $request->validate([
            'country' => ['required', 'integer'],
            'state' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255']
        ]); // validation

        $type = new City();
        $type->name = $request->name;
        $type->state_id = $request->state;
        $type->country_id = $request->country;
        $type->save();

        Notify::createdNotification();
        return to_route('admin.cities.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cities = City::findOrFail($id);
        $countries = Country::all();
        $states = State::where('country_id', $cities->country_id)->get();
        return view('admin.Location.City.create', compact('countries', 'states', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        //
        $request->validate([
            'country' => ['required', 'integer'],
            'state' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255']
        ]); // validation

        $type = City::findOrFail($id);
        $type->name = $request->name;
        $type->state_id = $request->state;
        $type->country_id = $request->country;
        $type->save();

        Notify::updatedNotification();
        return to_route('admin.cities.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        try {
            City::findOrFail($id)->delete();
            Notify::deletedNotification();
            return response(['message' => 'success'], 200);
        } catch (\Exception $e) {
            logger($e);
            // dd($e);
            return response(['message' => 'Something went wrong please try again!'], 500);
        }
    }
}
