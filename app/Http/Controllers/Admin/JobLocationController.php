<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobLocationCreateRequest;
use App\Http\Requests\JobLocationUpdateRequest;
use App\Models\Country;
use App\Models\JobLocation;
use App\Services\Notify;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobLocationController extends Controller
{

    use FileUploadTrait;

    function __construct()
    {
        $this->middleware(['permission:job location create|job location update|job location delete'])->only(['index']);
        $this->middleware(['permission:job location create'])->only(['create', 'store']);
        $this->middleware(['permission:job location update'])->only(['edit', 'update']);
        $this->middleware(['permission:job location delete'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {

        $locations = JobLocation::paginate(20);
        return view('admin.job-location.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $countries = Country::all();

        return view('admin.job-location.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobLocationCreateRequest $request)
    {
        // dd($request->all());
        $imagePath = $this->uploadFile($request, 'image');

        $data = $request->all();
        $data['image'] = $imagePath;
        JobLocation::create($data);

        Notify::createdNotification();

        return to_route('admin.job-location.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $location = JobLocation::findOrFail($id);
        $countries = Country::all();
        return view('admin.job-location.create', compact('location', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobLocationUpdateRequest $request, string $id)
    {
        $imagePath = $this->uploadFile($request, 'image');
        $data = $request->all();

        if ($imagePath) $data['image'] = $imagePath;

        JobLocation::findOrFail($id)->update(
            $data
        );

        Notify::updatedNotification();

        return to_route('admin.job-location.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            JobLocation::findOrFail($id)->delete();
            Notify::deletedNotification();
            return response(['message' => 'success'], 200);
        } catch (\Exception $e) {
            logger($e);
            return response(['message' => 'Something Went Wrong Please Try Again!'], 500);
        }
    }
}
