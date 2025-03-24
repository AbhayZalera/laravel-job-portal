<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AboutUsUpdateRequest;
use App\Models\About;
use App\Services\Notify;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AboutController extends Controller
{
    use FileUploadTrait;

    function __construct()
    {
        $this->middleware(['permission:aboutus']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $about = About::first();
        return view('admin.about-us.index', compact('about'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(AboutUsUpdateRequest $request, string $id)
    {
        $imagePath = $this->uploadFile($request, 'image');

        $data = $request->all();
        if ($imagePath) $data['image'] = $imagePath;
        About::updateOrCreate(['id' => 1], $data);
        Notify::updatedNotification();

        return redirect()->back();
    }
}
