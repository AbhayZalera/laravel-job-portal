<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobCategoryCreateRequest;
use App\Http\Requests\JobCategoryUpdateRequest;
use App\Models\Job;
use App\Models\JobCategory;
use App\Services\Notify;
use App\Traits\Searchable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use Searchable;

    function __construct()
    {
        $this->middleware(['permission:job category create|job category update|job category delete'])->only(['index']);
        $this->middleware(['permission:job category create'])->only(['create', 'store']);
        $this->middleware(['permission:job category update'])->only(['edit', 'update']);
        $this->middleware(['permission:job category delete'])->only(['destroy']);
    }

    public function index(): View
    {
        $query = JobCategory::query();
        $this->search($query, ['name']);
        $categories = $query->paginate(10);
        return view('admin.job.job-category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.job.job-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobCategoryCreateRequest $request, JobCategory $jobCategory): RedirectResponse
    {
        // dd($request->all());
        JobCategory::create(
            [
                'icon' => $request->icon,
                'name' => $request->name,
                'show_at_popular' => $request->show_at_popular,
                'show_at_featured' => $request->show_at_featured
            ]
        );
        Notify::createdNotification();
        return redirect()->route('admin.job-categories.index');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $category = JobCategory::find($id);
        return view('admin.job.job-category.create', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobCategoryUpdateRequest $request, string $id)
    {
        // dd($request->all());
        $category = JobCategory::findOrFail($id);
        $icon = $request->filled('icon') ? $request->icon : $category->icon;
        $category->update(
            [
                'icon' => $icon,
                'name' => $request->name,
                'show_at_popular' => $request->show_at_popular,
                'show_at_featured' => $request->show_at_featured
            ]
        );
        Notify::updatedNotification();
        return redirect()->route('admin.job-categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobExist = Job::where('job_category_id', $id)->exists();
        if ($jobExist) {
            return response(['message' => 'You can not delete this category because it has already used'], 500);
        }
        try {
            JobCategory::findOrFail($id)->delete();
            Notify::deletedNotification();
            return response(['message' => 'success'], 200);
        } catch (\Exception $e) {
            logger($e);
            // dd($e);
            return response(['message' => 'Something went wrong please try again!'], 500);
        }
    }
}
