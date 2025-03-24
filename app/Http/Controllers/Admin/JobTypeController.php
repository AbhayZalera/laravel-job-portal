<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobType;
use App\Services\Notify;
use App\Traits\Searchable;
use Illuminate\Http\Request;

class JobTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use Searchable;

    function __construct()
    {
        $this->middleware(['permission:jobtype create|jobtype update|jobtype delete'])->only(['index']);
        $this->middleware(['permission:jobtype create'])->only(['create', 'store']);
        $this->middleware(['permission:jobtype update'])->only(['edit', 'update']);
        $this->middleware(['permission:jobtype delete'])->only(['destroy']);
    }

    public function index()
    {
        $query = JobType::query();
        $this->search($query, ['name', 'slug']);
        $jobTypes = $query->paginate(10);
        return view('admin.job.job-type.index', compact('jobTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.job.job-type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
        ]);

        JobType::create(
            [
                'name' => $request->name
            ]
        );
        Notify::createdNotification();
        return redirect()->route('admin.job-type.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobType = JobType::findOrFail($id);
        return view('admin.job.job-type.create', compact('jobType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
        ]);
        JobType::findOrFail($id)->update(
            [
                'name' => $request->name
            ]
        );
        Notify::updatedNotification();
        return redirect()->route('admin.job-type.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobExist = Job::where('job_type_id', $id)->exists();
        if ($jobExist) {
            return response(['message' => 'You can not delete this Type because it has already used'], 500);
        }
        try {
            JobType::findOrFail($id)->delete();
            Notify::deletedNotification();
            return response(['message' => 'success'], 200);
        } catch (\Exception $e) {
            logger($e);
            // dd($e);
            return response(['message' => 'Something went wrong please try again!'], 500);
        }
    }
}
