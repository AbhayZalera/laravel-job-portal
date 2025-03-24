<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\OrganizationType;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\Notify;
use App\Traits\Searchable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class OrganizationTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use Searchable;

    function __construct()
    {
        $this->middleware(['permission:organization create|organization update|organization delete'])->only(['index']);
        $this->middleware(['permission:organization create'])->only(['create', 'store']);
        $this->middleware(['permission:organization update'])->only(['edit', 'update']);
        $this->middleware(['permission:organization delete'])->only(['destroy']);
    }

    public function index(): View
    {
        //
        $query = OrganizationType::query();
        $this->search($query, ['name']);
        $organizationTypes = $query->paginate(20);
        return view('admin.organization-type.index', compact('organizationTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {

        return view('admin.organization-type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        // dd($request->all());
        $request->validate([
            'name' => ['required', 'max:255', 'unique:organization_types,name']
        ]); // validation

        $type = new OrganizationType();
        $type->name = $request->name;
        $type->save();

        Notify::createdNotification();


        return to_route('admin.organization-type.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $organizationType = OrganizationType::findOrFail($id);
        return view('admin.organization-type.create', compact('organizationType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'max:255', 'unique:organization_types,name,' . $id]
        ]); // validation

        $type = OrganizationType::findOrFail($id);
        $type->name = $request->name;
        $type->save();

        Notify::updatedNotification();


        return to_route('admin.organization-type.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): Response
    {
        //dd($id);
        $companyExist = Company::where('organization_type_id', $id)->exists();
        if ($companyExist) {
            return response(['message' => 'You can not delete this Organization because it has already used'], 500);
        }
        try {
            OrganizationType::findOrFail($id)->delete();
            Notify::deletedNotification();
            return response(['message' => 'success'], 200);
        } catch (\Exception $e) {
            logger($e);
            // dd($e);
            return response(['message' => 'Something went wrong please try again!'], 500);
        }
    }
}
