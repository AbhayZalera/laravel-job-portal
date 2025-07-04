<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Experience;
use App\Models\Skill;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FrontendCandidatePageController extends Controller
{
    //
    function index(Request $request): View
    {
        // dd($request->all());
        $skills = Skill::all();
        $experiences = Experience::all();
        $query = Candidate::query();
        $query->where(['profile_complate' => 1, 'visibility' => 1]);
        if ($request->has('skills') && $request->filled('skills')) {
            $ids = Skill::whereIn('slug', $request->skills)->pluck('id')->toArray();
            $query->whereHas('skills', function ($subquery) use ($ids) {
                $subquery->whereIn('skill_id', $ids);
            });
        }
        if ($request->has('experience') && $request->filled('experience')) {
            $query->where(
                'experience_id',
                $request->experience
            );
        }
        $candidates = $query->paginate(24);

        return view('frontend.pages.candidate-index', compact('candidates', 'skills', 'experiences'));
    }

    function show(string $slug): View
    {
        $candidate = Candidate::where(['profile_complate' => 1, 'visibility' => 1, 'slug' => $slug])->firstOrFail();
        return view('frontend.pages.candidate-details', compact('candidate'));
    }
}
