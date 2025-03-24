<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomPageBuilder;
use App\Services\Notify;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomPageBuilderController extends Controller
{
    use Searchable;

    function __construct()
    {
        $this->middleware(['permission:pagebuilder create|pagebuilder update|pagebuilder delete'])->only(['index']);
        $this->middleware(['permission:pagebuilder create'])->only(['create', 'store']);
        $this->middleware(['permission:pagebuilder update'])->only(['edit', 'update']);
        $this->middleware(['permission:pagebuilder delete'])->only(['destroy']);
    }

    public function index(): View
    {
        $query = CustomPageBuilder::query();
        $this->search($query, ['page_name']);
        $pages = $query->orderBy('id', 'DESC')->paginate(20);
        return view('admin.page-builder.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.page-builder.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'page_name' => ['required', 'max:255'],
            'content' => ['required']
        ]);
        $data = $request->all();
        CustomPageBuilder::create($data);

        Notify::createdNotification();

        return to_route('admin.page-builder.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $page = CustomPageBuilder::findOrFail($id);
        return view('admin.page-builder.create', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'page_name' => ['required', 'max:255'],
            'content' => ['required']
        ]);

        $data = $request->all();
        CustomPageBuilder::findOrFail($id)->update($data);

        Notify::updatedNotification();

        return to_route('admin.page-builder.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            CustomPageBuilder::findOrFail($id)->delete();
            Notify::deletedNotification();
            return response(['message' => 'success'], 200);
        } catch (\Exception $e) {
            logger($e);
            return response(['message' => 'Something Went Wrong Please Try Again!'], 500);
        }
    }
}
