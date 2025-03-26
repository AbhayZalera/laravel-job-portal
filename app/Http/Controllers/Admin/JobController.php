<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobCreateRequest;
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
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use Searchable;

    function __construct()
    {
        $this->middleware(['permission:job create|job update|job delete'])->only(['index']);
        $this->middleware(['permission:job create'])->only(['create', 'store']);
        $this->middleware(['permission:job update'])->only(['edit', 'update', 'changeStatus']);
        $this->middleware(['permission:job delete'])->only(['destroy']);
    }

    public function index(): View
    {
        $query = Job::query();
        $this->search($query, ['title', 'slug']);
        $jobs = $query->orderBy('id', 'DESC')->paginate(20);
        return view('admin.job.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
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
        return view('admin.job.create', compact(
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
    public function store(JobCreateRequest $request, Job $job): RedirectResponse
    {
        // dd($request->all());
        $job = Job::create([
            'title' => $request->title,
            'company_id' => $request->company,
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
        Notify::createdNotification();

        return redirect()->route('admin.jobs.index');
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
        $job = Job::findOrFail($id);
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
        return view('admin.job.create', compact(
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
    public function update(JobCreateRequest $request, string $id): RedirectResponse
    {
        $job = Job::findOrFail($id);

        // Use update() for mass assignment
        $job->update([
            'title' => $request->title,
            'company_id' => $request->company,
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

        Notify::updatedNotification();
        return redirect()->route('admin.jobs.index');
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

    function changeStatus(string $id): Response
    {
        // dd('working');
        $job = Job::findOrFail($id);
        $job->status = $job->status == 'active' ? 'pending' : 'active';
        // dd($job->status);
        $job->save();
        Notify::updatedNotification();
        return response(['message' => 'success'], 200);
    }
}
