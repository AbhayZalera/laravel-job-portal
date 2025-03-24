<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\IndustryType;
use App\Services\Notify;
use App\Traits\Searchable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;


class IndustryTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use Searchable;

    function __construct()
    {
        $this->middleware(['permission:industry create|industry update|industry delete'])->only(['index']);
        $this->middleware(['permission:industry create'])->only(['create', 'store']);
        $this->middleware(['permission:industry update'])->only(['edit', 'update']);
        $this->middleware(['permission:industry delete'])->only(['destroy']);
    }

    public function index(Request $request): View
    {
        // dd($request->search);
        // dd(request('search'));
        $query = IndustryType::query();
        $this->search($query, ['name']);
        $industryTypes = $query->paginate(20);
        return view('admin.industry-type.index', compact('industryTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        //
        return view('admin.industry-type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // dd($request->all());
        $request->validate([
            'name' => ['required', 'max:255', 'unique:industry_types,name']
        ]); // validation

        $type = new IndustryType();
        $type->name = $request->name;
        $type->save();

        Notify::createdNotification();


        return to_route('admin.industry-type.index');
    }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $industryType = IndustryType::findOrFail($id);
        return view('admin.industry-type.create', compact('industryType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        // dd($request->all());
        $request->validate([
            'name' => ['required', 'max:255', 'unique:industry_types,name,' . $id]
        ]); // validation

        $type = IndustryType::findOrFail($id);
        $type->name = $request->name;
        $type->save();

        Notify::updatedNotification();


        return to_route('admin.industry-type.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        // dd($id);
        $companyExist = Company::where('industry_type_id', $id)->exists();
        if ($companyExist) {
            return response(['message' => 'You can not delete this Industry because it has already used'], 500);
        }
        try {
            IndustryType::findOrFail($id)->delete();
            Notify::deletedNotification();
            return response(['message' => 'success'], 200);
        } catch (\Exception $e) {
            logger($e);
            // dd($e);
            return response(['message' => 'Something went wrong please try again!'], 500);
        }
    }
}
