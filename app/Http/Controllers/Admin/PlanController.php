<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PlanCreateRequest;
use App\Models\Plan;
use App\Services\Notify;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:plan create|plan update|plan delete'])->only(['index']);
        $this->middleware(['permission:plan create'])->only(['create', 'store']);
        $this->middleware(['permission:plan update'])->only(['edit', 'update']);
        $this->middleware(['permission:plan delete'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = Plan::all();
        return view('admin.plan.index', compact('plans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.plan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PlanCreateRequest $request)
    {
        // dd($request->allall());
        $plan = Plan::create($request->all());
        Notify::createdNotification();

        return to_route('admin.plans.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $plan = Plan::findOrFail($id);
        return view('admin.plan.create', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PlanCreateRequest $request, string $id)
    {
        // dd($request->all());
        $plan = Plan::findOrFail($id);
        $plan->update($request->all());
        Notify::updatedNotification();
        return to_route('admin.plans.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Plan::findOrFail($id)->delete();
            Notify::deletedNotification();
            return response(['message' => 'success'], 200);
        } catch (\Exception $e) {
            logger($e);
            // dd($e);
            return response(['message' => 'Something went wrong please try again!'], 500);
        }
    }
}
