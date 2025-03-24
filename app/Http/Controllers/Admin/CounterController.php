<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CounterRequest;
use App\Models\Counter;
use App\Services\Notify;
use Illuminate\Http\Request;
use Illuminate\View\View;
use PHPUnit\Framework\Constraint\Count;

class CounterController extends Controller
{
    function __construct()
    {
        $this->middleware(['permission:sections']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $counter = Counter::first();
        return view('admin.counter.index', compact('counter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CounterRequest $request, string $id)
    {

        Counter::updateOrCreate(
            ['id' => 1],
            [
                'counter_one' => $request->counter_one,
                'title_one' => $request->title_one,
                'counter_two' => $request->counter_two,
                'title_two' => $request->title_two,
                'counter_three' => $request->counter_three,
                'title_three' => $request->title_three,
                'counter_four' => $request->counter_four,
                'title_four' => $request->title_four,
            ]
        );
        Notify::updatedNotification();

        return redirect()->back();
    }
}
