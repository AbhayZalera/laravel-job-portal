<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobCreateRequest;
use App\Http\Requests\Frontend\JobCreateRequest as FrontendJobCreateRequest;
use App\Http\Requests\JobApiCreateRequest;
use App\Models\Job;
use App\Traits\Searchable;
use Illuminate\Http\Request;

class ApiJobController extends Controller
{
    use Searchable;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Job::query();
        $this->search($query, ['title', 'slug']);
        $jobs = $query->orderBy('id', 'DESC')->paginate(20);
        return $jobs;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobApiCreateRequest $request)
    {
        // dd($request->all());
        $job = Job::create($request->all());
        return $request->input();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobApiCreateRequest $request, string $id)
    {
        $job = Job::findOrFail($id);
        $job->update($request->all());
        return $request->input();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $job = Job::destroy($id);
        if ($job) {
            return 'Record Delete';
        } else {
            return 'Record Not Found';
        }
    }
}
