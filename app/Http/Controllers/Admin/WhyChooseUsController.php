<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WhyChooseUSRequest;
use App\Models\WhyChooseUs;
use App\Services\Notify;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WhyChooseUsController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:whychooseus']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $whyChooseUs = WhyChooseUs::first();
        return view('admin.why-choose-us.index', compact('whyChooseUs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WhyChooseUSRequest $request, string $id)
    {
        $data = $request->all();

        if ($request->filled('icon_one')) $data['icon_one'] = $request->icon_one;
        if ($request->filled('icon_two')) $data['icon_two'] = $request->icon_two;
        if ($request->filled('icon_three')) $data['icon_three'] = $request->icon_three;

        WhyChooseUs::updateOrCreate(
            ['id' => 1],
            $data
        );

        Notify::updatedNotification();

        return redirect()->back();
    }
}
