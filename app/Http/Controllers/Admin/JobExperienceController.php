<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Job;
use App\Models\JobExperience;
use App\Services\Notify;
use App\Traits\Searchable;
use Illuminate\Http\Request;

class JobExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use Searchable;

    function __construct()
    {
        $this->middleware(['permission:experience create|experience update|experience delete'])->only(['index']);
        $this->middleware(['permission:experience create'])->only(['create', 'store']);
        $this->middleware(['permission:experience update'])->only(['edit', 'update']);
        $this->middleware(['permission:experience delete'])->only(['destroy']);
    }

    public function index()
    {
        $query = JobExperience::query();
        $this->search($query, ['name', 'slug']);
        $jobExperiences = $query->paginate(10);
        return view('admin.job.job-experiences.index', compact('jobExperiences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.job.job-experiences.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
        ]);

        JobExperience::create(
            [
                'name' => $request->name
            ]
        );
        Notify::createdNotification();
        return redirect()->route('admin.job-experiences.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobExperience = JobExperience::findOrFail($id);
        return view('admin.job.job-experiences.create', compact('jobExperience'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
        ]);
        JobExperience::findOrFail($id)->update(
            [
                'name' => $request->name
            ]
        );
        Notify::updatedNotification();
        return redirect()->route('admin.job-experiences.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobExist = Job::where('job_experience_id', $id)->exists();
        $candidateExist = Candidate::where('experience_id', $id)->exists();
        if ($jobExist || $candidateExist) {
            return response(['message' => 'You can not delete this Experience because it has already used'], 500);
        }

        try {
            JobExperience::findOrFail($id)->delete();
            Notify::deletedNotification();
            return response(['message' => 'success'], 200);
        } catch (\Exception $e) {
            logger($e);
            // dd($e);
            return response(['message' => 'Something went wrong please try again!'], 500);
        }
    }
}
