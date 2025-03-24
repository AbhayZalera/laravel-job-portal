<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\AppliedJob;
use App\Services\Notify;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Response;

class CandidateMyJobController extends Controller
{
    function index(): View
    {
        $appliedJobs = AppliedJob::with('job')->where('candidate_id', auth()->user()?->candidate?->id)->paginate(10);
        // dd($appliedJobs);
        return view('frontend.candidate-dashboard.my-job.index', compact('appliedJobs'));
    }
}
