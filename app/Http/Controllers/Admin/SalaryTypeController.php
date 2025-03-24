<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\SalaryType;
use App\Services\Notify;
use App\Traits\Searchable;
use Illuminate\Http\Request;

class SalaryTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use Searchable;

    function __construct()
    {
        $this->middleware(['permission:salarytype create|salarytype update|salarytype delete'])->only(['index']);
        $this->middleware(['permission:salarytype create'])->only(['create', 'store']);
        $this->middleware(['permission:salarytype update'])->only(['edit', 'update']);
        $this->middleware(['permission:salarytype delete'])->only(['destroy']);
    }

    public function index()
    {
        $query = SalaryType::query();
        $this->search($query, ['name', 'slug']);
        $salaryTypes = $query->paginate(10);
        return view('admin.job.salary-type.index', compact('salaryTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.job.salary-type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
        ]);

        SalaryType::create(
            [
                'name' => $request->name
            ]
        );
        Notify::createdNotification();
        return redirect()->route('admin.salary-type.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $salaryType = SalaryType::findOrFail($id);
        return view('admin.job.salary-type.create', compact('salaryType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
        ]);
        SalaryType::findOrFail($id)->update(
            [
                'name' => $request->name
            ]
        );
        Notify::updatedNotification();
        return redirect()->route('admin.salary-type.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobExist = Job::where('salary_type_id', $id)->exists();
        if ($jobExist) {
            return response(['message' => 'You can not delete this Type because it has already used'], 500);
        }
        try {
            SalaryType::findOrFail($id)->delete();
            Notify::deletedNotification();
            return response(['message' => 'success'], 200);
        } catch (\Exception $e) {
            logger($e);
            // dd($e);
            return response(['message' => 'Something went wrong please try again!'], 500);
        }
    }
}
