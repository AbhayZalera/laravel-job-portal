<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Profession;
use App\Services\Notify;
use App\Traits\Searchable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use Searchable;

    function __construct()
    {
        $this->middleware(['permission:profession create|profession update|profession delete'])->only(['index']);
        $this->middleware(['permission:profession create'])->only(['create', 'store']);
        $this->middleware(['permission:profession update'])->only(['edit', 'update']);
        $this->middleware(['permission:profession delete'])->only(['destroy']);
    }

    public function index(): View
    {
        $query = Profession::query();
        $this->search($query, ['name']);
        $professions = $query->paginate(20);
        return view('admin.profession.index', compact('professions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        //
        return view('admin.profession.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => ['required', 'max:255', 'unique:professions,name']
        ]); // validation
        $profession = new Profession();
        $profession->name = $request->name;
        $profession->save();
        Notify::createdNotification();
        return to_route('admin.profession.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        //
        $profession = Profession::findOrFail($id);
        return view('admin.profession.create', compact('profession'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'max:255', 'unique:languages,name,' . $id]
        ]); // validation
        $profession = Profession::findOrFail($id);
        $profession->name = $request->name;
        $profession->save();
        Notify::updatedNotification();
        return to_route('admin.profession.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $candidateExist = Candidate::where('profession_id', $id)->exists();
        if ($candidateExist) {
            return response(['message' => 'You can not delete this Profession because it has already used'], 500);
        }
        try {
            Profession::findOrFail($id)->delete();
            Notify::deletedNotification();
            return response(['message' => 'success'], 200);
        } catch (\Exception $e) {
            logger($e);
            // dd($e);
            return response(['message' => 'Something went wrong please try again!'], 500);
        }
    }
}
