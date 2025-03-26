<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContryUpdateRequest;
use App\Http\Requests\CountryCreateRequest;
use App\Models\Country;
use App\Services\Notify;
use App\Traits\Searchable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;


class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use Searchable;

    function __construct()
    {
        $this->middleware(['permission:country create|country update|country delete'])->only(['index']);
        $this->middleware(['permission:country create'])->only(['create', 'store']);
        $this->middleware(['permission:country update'])->only(['edit', 'update']);
        $this->middleware(['permission:country delete'])->only(['destroy']);
    }

    public function index(): View
    {
        $query = Country::query();
        $this->search($query, ['name']);
        $countries = $query->paginate(50);
        return view('admin.Location.Country.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        //
        return view('admin.Location.Country.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CountryCreateRequest $request): RedirectResponse
    {
        $country = Country::create($request->all());

        Notify::createdNotification();

        return to_route('admin.countries.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $countries = Country::findOrFail($id);
        return view('admin.Location.Country.create', compact('countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContryUpdateRequest $request, string $id): RedirectResponse
    {

        $country = Country::findOrFail($id);
        $country->update($request->all());
        // $country->update($request->all());
        // $type->name = $request->name;
        // $type->save();


        Notify::updatedNotification();

        return to_route('admin.countries.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        //
        // dd($id);
        try {
            Country::findOrFail($id)->delete();
            Notify::deletedNotification();
            return response(['message' => 'success'], 200);
        } catch (\Exception $e) {
            logger($e);
            // dd($e);
            return response(['message' => 'Something went wrong please try again!'], 500);
        }
    }
}
