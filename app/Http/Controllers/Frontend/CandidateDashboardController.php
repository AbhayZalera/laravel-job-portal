<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AppliedJob;
use App\Models\JobBookmark;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CandidateDashboardController extends Controller
{
    function index(): View
    {
        $jobAppliedCount = AppliedJob::where('candidate_id', auth()->user()->candidate?->id)->count();
        $userBookmarksCount = JobBookmark::where('candidate_id', auth()->user()->candidate?->id)->count();
        $appliedJobs = AppliedJob::with('job')->where('candidate_id', auth()->user()?->candidate?->id)->orderBy('id', 'DESC')->take(3)->get();
        return view('frontend.candidate-dashboard.dashboard', compact('jobAppliedCount', 'userBookmarksCount', 'appliedJobs'));
    }
}
