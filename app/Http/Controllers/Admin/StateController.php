<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\State;
use App\Services\Notify;
use App\Traits\Searchable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use Searchable;

    function __construct()
    {
        $this->middleware(['permission:state create|state update|state delete'])->only(['index']);
        $this->middleware(['permission:state create'])->only(['create', 'store']);
        $this->middleware(['permission:state update'])->only(['edit', 'update']);
        $this->middleware(['permission:state delete'])->only(['destroy']);
    }

    public function index(): View
    {
        //
        $query = State::query();
        $query->with('country');
        $this->search($query, ['name']);
        $states = $query->paginate(20);
        return view('admin.Location.State.index', compact('states'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        //
        $countries = Country::all();
        return view('admin.Location.State.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
        //dd($request->all());
        $request->validate([
            'name' => ['required', 'max:255'],
            'country' => ['required', 'integer']
        ]); // validation

        $type = new State();
        $type->name = $request->name;
        $type->country_id = $request->country;
        $type->save();

        Notify::createdNotification();
        return to_route('admin.states.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $countries = Country::all();
        $states = State::findOrFail($id);
        return view('admin.Location.State.create', compact('states', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        //
        //dd($request->all());
        $request->validate([
            'name' => ['required', 'max:255'],
            'country' => ['required', 'integer']
        ]); // validation

        $type = State::findOrFail($id);
        $type->name = $request->name;
        $type->country_id = $request->country;
        $type->save();

        Notify::updatedNotification();
        return to_route('admin.states.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        //
        // dd($id);
        try {
            State::findOrFail($id)->delete();
            Notify::deletedNotification();
            return response(['message' => 'success'], 200);
        } catch (\Exception $e) {
            logger($e);
            // dd($e);
            return response(['message' => 'Something went wrong please try again!'], 500);
        }
    }
}
