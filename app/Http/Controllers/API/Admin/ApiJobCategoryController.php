<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobCategoryCreateRequest;
use App\Http\Requests\JobCategoryUpdateRequest;
use App\Models\JobCategory;
use App\Traits\Searchable;
use Illuminate\Http\Request;

class ApiJobCategoryController extends Controller
{
    use Searchable;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = JobCategory::query();
        $this->search($query, ['name']);
        $jobcategory = $query->paginate(20);
        return $jobcategory;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobCategoryCreateRequest $request)
    {
        $jobcategory = JobCategory::create($request->all());
        return $request->input();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobCategoryUpdateRequest $request, string $id)
    {
        $jobcategory = JobCategory::findOrFail($id);
        $jobcategory->update($request->all());
        return $request->input();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobcategory = JobCategory::destroy($id);
        if ($jobcategory) {
            return 'Record Delete';
        } else {
            return 'Record Not Found';
        }
    }
}
