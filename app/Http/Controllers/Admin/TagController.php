<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobTag;
use App\Models\Tag;
use App\Services\Notify;
use App\Traits\Searchable;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use Searchable;

    function __construct()
    {
        $this->middleware(['permission:tag create|tag update|tag delete'])->only(['index']);
        $this->middleware(['permission:tag create'])->only(['create', 'store']);
        $this->middleware(['permission:tag update'])->only(['edit', 'update']);
        $this->middleware(['permission:tag delete'])->only(['destroy']);
    }

    public function index()
    {
        $query = Tag::query();
        $this->search($query, ['name', 'slug']);
        $tags = $query->paginate(10);
        return view('admin.job.tag.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.job.tag.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
        ]);

        Tag::create(
            [
                'name' => $request->name
            ]
        );
        Notify::createdNotification();
        return redirect()->route('admin.tag.index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tag = Tag::findOrFail($id);
        return view('admin.job.tag.create', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'max:255'],
        ]);
        Tag::findOrFail($id)->update(
            [
                'name' => $request->name
            ]
        );
        Notify::updatedNotification();
        return redirect()->route('admin.tag.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tagExist = JobTag::where('tag_id', $id)->exists();
        if ($tagExist) {
            return response(['message' => 'You can not delete this Tag because it has already used'], 500);
        }
        try {
            Tag::findOrFail($id)->delete();
            Notify::deletedNotification();
            return response(['message' => 'success'], 200);
        } catch (\Exception $e) {
            logger($e);
            // dd($e);
            return response(['message' => 'Something went wrong please try again!'], 500);
        }
    }
}
