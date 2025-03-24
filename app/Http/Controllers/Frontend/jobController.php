<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\JobCreateRequest;
use App\Models\AppliedJob;
use App\Models\Benifits;
use App\Models\City;
use App\Models\Company;
use App\Models\Country;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Job;
use App\Models\JobBenifits;
use App\Models\JobCategory;
use App\Models\JobRole;
use App\Models\JobSkills;
use App\Models\JobTag;
use App\Models\JobType;
use App\Models\SalaryType;
use App\Models\Skill;
use App\Models\State;
use App\Models\Tag;
use App\Services\Notify;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\View\View;
use Response;

class jobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use Searchable;
    public function index(): View
    {
        //
        $query = Job::query();
        $query->withCount('application');
        $this->search($query, ['title', 'slug']);
        $jobs = $query->where('company_id', auth()->user()->company?->id)->orderBy('id', 'DESC')->paginate(20);
        // dd($jobs);
        return view('frontend.company-dashboard.Jobs.index', compact('jobs'));
    }

    function applications(string $id): View
    {
        $applications = AppliedJob::where('job_id', $id)->paginate(5);
        // dd($applications);
        $jobTitle = Job::select('title')->where('id', $id)->first();
        return view('frontend.company-dashboard.applications.index', compact('applications', 'jobTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|RedirectResponse
    {
        storePlanInformation();
        $userPlan = session('user_plan');
        if (!empty($userPlan)) {
            if ($userPlan?->job_limit < 1) {
                Notify::errorNotification('You Have reached your plan limit please upgrade your plan');
                return to_route('company.jobs.index');
            }
        } else {
            Notify::errorNotification('Purchase Plan First For Post Job');
            return to_route('company.jobs.index');
        }

        $companies = Company::where(['profile_completion' => 1, 'visibility' => 1])->get();
        $categories = JobCategory::all();
        $countries = Country::all();
        $salaryTypes = SalaryType::all();
        $experiences = Experience::all();
        $jobRoles = JobRole::all();
        $educations = Education::all();
        $jobTypes = JobType::all();
        $tags = Tag::all();
        $skills = Skill::all();
        return view('frontend.company-dashboard.Jobs.create', compact(
            'companies',
            'categories',
            'countries',
            'salaryTypes',
            'experiences',
            'jobRoles',
            'educations',
            'jobTypes',
            'tags',
            'skills'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobCreateRequest $request)
    {
        // dd($request->all());

        if (isset($request->featured)) {
            if (session('user_plan')->featured_job_limit < 0) {
                Notify::errorNotification('You have reached your Featured job limit please upgrade your plan');
                return redirect()->back();
            }
        }
        if (isset($request->highlight)) {
            if (session('user_plan')->highlight_job_limit < 0) {
                Notify::errorNotification('You have reached your Highlight job limit please upgrade your plan');
                return redirect()->back();
            }
        }

        $job = Job::create([
            'title' => $request->title,
            'company_id' => auth()->user()->company->id,
            'job_category_id' => $request->category,
            'vacancies' => $request->vacancies,
            'deadline' => $request->deadline,
            'country_id' => $request->country,
            'state_id' => $request->state,
            'city_id' => $request->city,
            'address' => $request->address,
            'salary_mode' => $request->salary_mode,
            'min_salary' => $request->min_salary,
            'max_salary' => $request->max_salary,
            'custom_salary' => $request->custom_salary,
            'salary_type_id' => $request->salary_type,
            'job_experience_id' => $request->experience,
            'job_role_id' => $request->job_role,
            'education_id' => $request->education,
            'job_type_id' => $request->job_type,
            'apply_on' => $request->receive_applications,
            'featured' => $request->featured ?? 0,
            'highlight' => $request->highlight ?? 0,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        // Insert tags
        foreach ($request->tags as $tag) {
            JobTag::create([
                'job_id' => $job->id,
                'tag_id' => $tag,
            ]);
        }

        // Insert benefits
        $benefits = explode(',', $request->benefits);

        foreach ($benefits as $benefit) {
            $createBenefit = Benifits::create([
                'company_id' => $job->company_id,
                'name' => $benefit,
            ]);

            JobBenifits::create([
                'job_id' => $job->id,
                'benifit_id' => $createBenefit->id,
            ]);
        }

        // Insert skills
        foreach ($request->skills as $skill) {
            JobSkills::create([
                'job_id' => $job->id,
                'skill_id' => $skill,
            ]);
        }

        if ($job) {
            $userPlan = auth()->user()->company->userPlan;
            $userPlan->job_limit = $userPlan->job_limit - 1;
            if ($job->featured == 1) {
                $userPlan->featured_job_limit = $userPlan->featured_job_limit - 1;
            }
            if ($job->highlight == 1) {
                $userPlan->highlight_job_limit = $userPlan->highlight_job_limit - 1;
            }
            $userPlan->save();
            storePlanInformation();
        }
        Notify::createdNotification();

        return redirect()->route('company.jobs.index');
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
        storePlanInformation();
        $job = Job::findOrFail($id);

        abort_if($job->company_id !== auth()->user()->company->id, 404);
        $companies = Company::where(['profile_completion' => 1, 'visibility' => 1])->get();
        $categories = JobCategory::all();
        $countries = Country::all();
        $states = State::where('country_id', $job->country_id)->get();
        $cities = City::where('state_id', $job->state_id)->get();
        $salaryTypes = SalaryType::all();
        $experiences = Experience::all();
        $jobRoles = JobRole::all();
        $educations = Education::all();
        $jobTypes = JobType::all();
        $tags = Tag::all();
        $skills = Skill::all();
        return view('frontend.company-dashboard.Jobs.create', compact(
            'job',
            'companies',
            'categories',
            'countries',
            'states',
            'cities',
            'salaryTypes',
            'experiences',
            'jobRoles',
            'educations',
            'jobTypes',
            'tags',
            'skills'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobCreateRequest $request, string $id)
    {

        $job = Job::findOrFail($id);
        $userPlan = session('user_plan');
        // dd($userPlan);
        $oldFeatured = $job->featured;
        $oldHighlight = $job->highlight;

        $newFeatured = $request->featured ?? 0;
        $newHighlight = $request->highlight ?? 0;
        // dd($newFeatured + $newHighlight);
        if (!$oldFeatured && $newFeatured) {
            if ($userPlan->featured_job_limit > 0) {
                $userPlan->featured_job_limit -= 1;
            } else {
                Notify::errorNotification('You have reached your Featured job limit please upgrade your plan');
                return redirect()->back();
            }
        }

        if (!$oldHighlight && $newHighlight) {
            if ($userPlan->highlight_job_limit > 0) {
                $userPlan->highlight_job_limit -= 1;
            } else {
                Notify::errorNotification('You have reached your Highlight job limit please upgrade your plan');
                return redirect()->back();
            }
        }


        $job->update([
            'title' => $request->title,
            // 'company_id' => $request->company,
            'job_category_id' => $request->category,
            'vacancies' => $request->vacancies,
            'deadline' => $request->deadline,
            'country_id' => $request->country,
            'state_id' => $request->state,
            'city_id' => $request->city,
            'address' => $request->address,
            'salary_mode' => $request->salary_mode,
            'min_salary' => $request->min_salary,
            'max_salary' => $request->max_salary,
            'custom_salary' => $request->custom_salary,
            'salary_type_id' => $request->salary_type,
            'job_experience_id' => $request->experience,
            'job_role_id' => $request->job_role,
            'education_id' => $request->education,
            'job_type_id' => $request->job_type,
            'apply_on' => $request->receive_applications,
            'featured' => $request->featured ?? 0,
            'highlight' => $request->highlight ?? 0,
            'description' => $request->description,
            'status' => 'active',
        ]);

        // Update Tags
        JobTag::where('job_id', $id)->delete();
        foreach ($request->tags as $tag) {
            JobTag::create(['job_id' => $job->id, 'tag_id' => $tag]);
        }

        // Update Benefits
        $selectedBenefits = JobBenifits::where('job_id', $id);
        foreach ($selectedBenefits->get() as $selectedBenefit) {
            Benifits::find($selectedBenefit->benifit_id)?->delete();
        }
        $selectedBenefits->delete();

        $benefits = explode(',', $request->benefits);
        foreach ($benefits as $benefit) {
            $createBenefit = Benifits::create([
                'company_id' => $job->company_id,
                'name' => $benefit
            ]);
            JobBenifits::create([
                'job_id' => $job->id,
                'benifit_id' => $createBenefit->id
            ]);
        }

        // Update Skills
        JobSkills::where('job_id', $id)->delete();
        foreach ($request->skills as $skill) {
            JobSkills::create(['job_id' => $job->id, 'skill_id' => $skill]);
        }
        $userPlan->save();
        storePlanInformation();

        Notify::updatedNotification();
        return redirect()->route('company.jobs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Job::findOrFail($id)->delete();
            Notify::deletedNotification();
            return response(['message' => 'success'], 200);
        } catch (\Exception $e) {
            logger($e);
            return response(['message' => 'Something Went Wrong Please Try Again!'], 500);
        }
    }

    //Approve Candidate
    function approve(string $id): HttpResponse
    {
        // dd('working');
        $appliedJob = AppliedJob::findOrFail($id);
        $appliedJob->a_status = $appliedJob->a_status == 'active' ? 'pending' : 'active';
        // dd($job->status);
        $appliedJob->save();
        Notify::updatedNotification();
        return response(['message' => 'success'], 200);
    }
}
