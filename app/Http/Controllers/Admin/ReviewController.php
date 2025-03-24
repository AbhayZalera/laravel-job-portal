<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReviewCreateRequest;
use App\Http\Requests\ReviewUpdateRequest;
use App\Models\Review;
use App\Services\Notify;
use App\Traits\FileUploadTrait;
use App\Traits\Searchable;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use FileUploadTrait, Searchable;

    function __construct()
    {
        $this->middleware(['permission:review create|review update|review delete'])->only(['index']);
        $this->middleware(['permission:review create'])->only(['create', 'store']);
        $this->middleware(['permission:review update'])->only(['edit', 'update']);
        $this->middleware(['permission:review delete'])->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $query = Review::query();
        $this->search($query, ['name', 'title', 'rating']);
        $reviews = $query->orderBy('id', 'DESC')->paginate(20);
        return view('admin.review.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.review.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReviewCreateRequest $request)
    {
        $imagePath = $this->uploadFile($request, 'image');

        $data = $request->all();
        $data['image'] = $imagePath;
        Review::create($data);

        Notify::createdNotification();
        return to_route('admin.reviews.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $review = Review::findOrFail($id);
        return view('admin.review.create', compact('review'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReviewUpdateRequest $request, string $id)
    {
        $imagePath = $this->uploadFile($request, 'image');
        $data = $request->all();
        if ($imagePath) $data['image'] = $imagePath;
        Review::findOrFail($id)->update(
            $data
        );
        Notify::updatedNotification();
        return to_route('admin.reviews.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Review::findOrFail($id)->delete();
            Notify::deletedNotification();
            return response(['message' => 'success'], 200);
        } catch (\Exception $e) {
            logger($e);
            return response(['message' => 'Something Went Wrong Please Try Again!'], 500);
        }
    }
}
