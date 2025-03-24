<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CandidateLanguage;
use App\Models\Language;
use App\Traits\Searchable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Services\Notify;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use Searchable;

    function __construct()
    {
        $this->middleware(['permission:language create|language update|language delete'])->only(['index']);
        $this->middleware(['permission:language create'])->only(['create', 'store']);
        $this->middleware(['permission:language update'])->only(['edit', 'update']);
        $this->middleware(['permission:language delete'])->only(['destroy']);
    }

    public function index(): View
    {
        //
        $query = Language::query();
        $this->search($query, ['name']);
        $languages = $query->paginate(20);
        return view('admin.language.index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        //
        return view('admin.language.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    { // dd($request->all());
        $request->validate([
            'name' => ['required', 'max:255', 'unique:languages,name']
        ]); // validation
        $language = new Language();
        $language->name = $request->name;
        $language->save();
        Notify::createdNotification();
        return to_route('admin.languages.index');
        //
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
        $languages = Language::findOrFail($id);
        return view('admin.language.create', compact('languages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'max:255', 'unique:languages,name,' . $id]
        ]); // validation
        $language = Language::findOrFail($id);
        $language->name = $request->name;
        $language->save();
        Notify::updatedNotification();
        return to_route('admin.languages.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $languageExist = CandidateLanguage::where('language_id', $id)->exists();
        if ($languageExist) {
            return response(['message' => 'You can not delete this Language because it has already used'], 500);
        }
        try {
            Language::findOrFail($id)->delete();
            Notify::deletedNotification();
            return response(['message' => 'success'], 200);
        } catch (\Exception $e) {
            logger($e);
            // dd($e);
            return response(['message' => 'Something went wrong please try again!'], 500);
        }
    }
}
