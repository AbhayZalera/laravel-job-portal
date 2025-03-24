<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogCreateRequest;
use App\Http\Requests\Admin\BlogUpdateRequest;
use App\Models\Blog;
use App\Services\Notify;
use App\Traits\FileUploadTrait;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    use FileUploadTrait, Searchable;

    function __construct()
    {
        $this->middleware(['permission:blog create|blog update|blog delete'])->only(['index']);
        $this->middleware(['permission:blog create'])->only(['create', 'store']);
        $this->middleware(['permission:blog update'])->only(['edit', 'update']);
        $this->middleware(['permission:blog delete'])->only(['destroy']);
    }

    public function index(): View
    {
        $query = Blog::query();
        $this->search($query, ['title']);
        $blogs = $query->latest()->paginate(20);
        return view('admin.blog.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogCreateRequest $request)
    {
        // dd($request->all());
        $imagePath = $this->uploadFile($request, 'image');
        $data = $request->all();

        $data['image'] = $imagePath;
        $data['author_id'] = auth()->user()->id;

        // dd($data);
        Blog::create(
            $data
        );
        Notify::createdNotification();
        return to_route('admin.blogs.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.blog.create', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogUpdateRequest $request, string $id)
    {
        $imagePath = $this->uploadFile($request, 'image');
        $data = $request->all();

        if ($imagePath) $data['image'] = $imagePath;
        $data['author_id'] = auth()->user()->id;
        // dd($data);
        // dd(auth()->user()->name);
        Blog::findOrFail($id)->update(
            $data
        );
        Notify::updatedNotification();
        return to_route('admin.blogs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Blog::findOrFail($id)->delete();
            Notify::deletedNotification();
            return response(['message' => 'success'], 200);
        } catch (\Exception $e) {
            logger($e);
            // dd($e);
            return response(['message' => 'Something went wrong please try again!'], 500);
        }
    }
}
