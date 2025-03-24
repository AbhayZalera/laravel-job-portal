<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\JobBookmark;
use App\Services\Notify;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CandidateJobBookmarkController extends Controller
{

    function index(): View
    {
        $bookmarks = JobBookmark::where('candidate_id', auth()->user()->candidateProfile?->id)->paginate(10);
        return view('frontend.candidate-dashboard.bookmarks.index', compact('bookmarks'));
    }
    function save(string $id)
    {
        if (!auth()->check()) {
            throw ValidationException::withMessages(['Please Login first for bookmark']);
        }

        if (auth()->check() && auth()->user()->role !== 'candidate') {
            throw ValidationException::withMessages(['only candidate will able to add book marks']);
        }
        if (auth()->check() && auth()->user()->candidate->profile_complate !== 1) {
            throw ValidationException::withMessages(['First Complete Your Profile']);
        }
        $alreadyMarked = JobBookmark::where(['job_id' => $id, 'candidate_id' => auth()->user()->candidateProfile->id])->exists();

        if ($alreadyMarked) {
            throw ValidationException::withMessages(['post is already bookmarked']);
        }
        $bookmark = JobBookmark::create([
            'job_id' => $id,
            'candidate_id' => auth()->user()->candidateProfile->id,
        ]);

        return response(['message' => 'bookmarked added successfully', 'id' => $id]);
    }

    public function destroy(string $id)
    {
        // dd('jay mataji');
        try {
            JobBookmark::findOrFail($id)->delete();
            Notify::deletedNotification();
            return response(['message' => 'success'], 200);
        } catch (\Exception $e) {
            logger($e);
            // dd($e);
            return response(['message' => 'Something went wrong please try again!'], 500);
        }
    }
}
