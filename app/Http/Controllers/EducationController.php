<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\Job;
use App\Services\Notify;
use App\Traits\Searchable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use Searchable;

    function __construct()
    {
        $this->middleware(['permission:education create|education update|education delete'])->only(['index']);
        $this->middleware(['permission:education create'])->only(['create', 'store']);
        $this->middleware(['permission:education update'])->only(['edit', 'update']);
        $this->middleware(['permission:education delete'])->only(['destroy']);
    }

    public function index(): View
    {
        $query = Education::query();
        $this->search($query, ['name', 'slug']);
        $educations = $query->paginate(10);
        return view('admin.job.education.index', compact('educations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.job.education.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // dd($request->all());
        $request->validate([
            'name' => ['required', 'max:255'],
        ]);

        Education::create(
            [
                'name' => $request->name
            ]
        );
        Notify::createdNotification();
        return redirect()->route('admin.educations.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $education = Education::findOrFail($id);
        return view('admin.job.education.create', compact('education'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'max:255'],
        ]);
        Education::findOrFail($id)->update(
            [
                'name' => $request->name
            ]
        );
        Notify::updatedNotification();
        return redirect()->route('admin.educations.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobExist = Job::where('education_id', $id)->exists();
        if ($jobExist) {
            return response(['message' => 'You can not delete this Education because it has already used'], 500);
        }
        try {
            Education::findOrFail($id)->delete();
            Notify::deletedNotification();
            return response(['message' => 'success'], 200);
        } catch (\Exception $e) {
            logger($e);
            // dd($e);
            return response(['message' => 'Something went wrong please try again!'], 500);
        }
    }
}
