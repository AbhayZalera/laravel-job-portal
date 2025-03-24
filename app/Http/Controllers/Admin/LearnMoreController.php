<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LearnMoreRequest;
use App\Models\LearnMore;
use App\Services\Notify;
use App\Traits\FileUploadTrait;
use Illuminate\Http\Request;

class LearnMoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use FileUploadTrait;

    function __construct()
    {
        $this->middleware(['permission:learnmore']);
    }

    public function index()
    {
        $learn = LearnMore::first();
        return view('admin.learn-more.index', compact('learn'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LearnMoreRequest $request, string $id)
    {


        $imagePath = $this->uploadFile($request, 'image');

        $formData =  [];
        if ($imagePath) $formData['image'] = $imagePath;

        $formData['title'] = $request->title;
        $formData['main_title'] = $request->main_title;
        $formData['sub_title'] = $request->sub_title;
        $formData['url'] = $request->url;


        LearnMore::updateOrCreate(
            ['id' => 1],
            $formData
        );
        Notify::updatedNotification();

        return redirect()->back();
    }
}
