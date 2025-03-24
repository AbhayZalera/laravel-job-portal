<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CandidateSkill;
use App\Models\JobSkills;
use App\Models\Skill;
use App\Services\Notify;
use App\Traits\Searchable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SkillController extends Controller
{
    use Searchable;
    /**
     * Display a listing of the resource.
     */

    function __construct()
    {
        $this->middleware(['permission:skill create|skill update|skill delete'])->only(['index']);
        $this->middleware(['permission:skill create'])->only(['create', 'store']);
        $this->middleware(['permission:skill update'])->only(['edit', 'update']);
        $this->middleware(['permission:skill delete'])->only(['destroy']);
    }

    public function index(): View
    {
        $query = Skill::query();
        $this->search($query, ['name']);
        $skills = $query->paginate(20);
        return view('admin.skill.index', compact('skills'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.skill.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'max:255', 'unique:professions,name']
        ]); // validation
        $profession = new Skill();
        $profession->name = $request->name;
        $profession->save();
        Notify::createdNotification();
        return to_route('admin.skill.index');
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
        // $skills = Skill::pluck('name', 'id');
        // $skills = Skill::all();
        // dd($skills);
        $skill = Skill::findOrFail($id);
        return view('admin.skill.create', compact('skill'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => ['required', 'max:255', 'unique:languages,name,' . $id]
        ]); // validation
        $skill = Skill::findOrFail($id);
        $skill->name = $request->name;
        $skill->save();
        Notify::updatedNotification();
        return to_route('admin.skill.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobSkillExist = JobSkills::where('skill_id', $id)->exists();
        $candidateSkillExist = CandidateSkill::where('skill_id', $id)->exists();
        if ($jobSkillExist || $candidateSkillExist) {
            return response(['message' => 'You can not delete this Skill because it has already used'], 500);
        }
        try {
            Skill::findOrFail($id)->delete();
            Notify::deletedNotification();
            return response(['message' => 'success'], 200);
        } catch (\Exception $e) {
            logger($e);
            // dd($e);
            return response(['message' => 'Something went wrong please try again!'], 500);
        }
    }
}
