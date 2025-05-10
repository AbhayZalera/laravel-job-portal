<?php

// namespace App\Http\Controllers\API\Admin;

// use App\Http\Controllers\Controller;
// use App\Http\Requests\Admin\JobCreateRequest;
// use App\Http\Requests\Frontend\JobCreateRequest as FrontendJobCreateRequest;
// use App\Http\Requests\JobApiCreateRequest;
// use App\Models\Job;
// use App\Traits\Searchable;
// use Illuminate\Http\Request;

// class ApiJobController extends Controller
// {
//     use Searchable;
//     /**
//      * Display a listing of the resource.
//      */
//     public function index()
//     {
//         $query = Job::query();
//         $this->search($query, ['title', 'slug']);
//         $jobs = $query->orderBy('id', 'DESC')->paginate(20);
//         return $jobs;
//     }

//     /**
//      * Store a newly created resource in storage.
//      */
//     public function store(JobApiCreateRequest $request)
//     {
//         // dd($request->all());
//         $job = Job::create($request->all());
//         return $request->input();
//     }

//     /**
//      * Update the specified resource in storage.
//      */
//     public function update(JobApiCreateRequest $request, string $id)
//     {
//         $job = Job::findOrFail($id);
//         $job->update($request->all());
//         return $request->input();
//     }

//     /**
//      * Remove the specified resource from storage.
//      */
//     public function destroy(string $id)
//     {
//         $job = Job::destroy($id);
//         if ($job) {
//             return 'Record Delete';
//         } else {
//             return 'Record Not Found';
//         }
//     }
// }

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobApiCreateRequest;
use App\Models\Job;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class ApiJobController extends Controller
{
    use Searchable;

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $query = Job::query();
            $this->search($query, ['title', 'slug']);
            $jobs = $query->orderBy('id', 'DESC')->paginate(2);

            return response()->json([
                'status' => true,
                'message' => 'Jobs retrieved successfully',
                'data' => $jobs
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobApiCreateRequest $request): JsonResponse
    {
        try {
            $job = Job::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Job created successfully',
                'data' => $job
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to create job',
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobApiCreateRequest $request, string $id): JsonResponse
    {
        try {
            $job = Job::findOrFail($id);
            $job->update($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Job updated successfully',
                'data' => $job
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update job',
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        try {
            $job = Job::find($id);
            if (!$job) {
                return response()->json([
                    'status' => false,
                    'message' => 'Job not found'
                ], 404);
            }

            $job->delete();
            return response()->json([
                'status' => true,
                'message' => 'Job deleted successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete job',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
