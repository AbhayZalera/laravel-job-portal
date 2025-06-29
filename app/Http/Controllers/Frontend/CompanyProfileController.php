<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\CompanyAccountInfoUpdateRequest;
use App\Http\Requests\Frontend\CompanyFoundingInfoUpdateRequest;
use App\Http\Requests\Frontend\CompanyInfoUpdateRequest;
use App\Models\City;
use App\Models\Company;
use App\Models\Country;
use App\Models\IndustryType;
use App\Models\OrganizationType;
use App\Models\State;
use App\Models\TeamSize;
use App\Services\Notify;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Traits\FileUploadTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class CompanyProfileController extends Controller
{
    use FileUploadTrait;
    function index(): View
    {
        //it work for all form companyInfo as well as founding and account bcz all data get in this variable
        $companyInfo = Company::Where('user_id', auth()->user()->id)->first();
        $industryTypes = IndustryType::all();
        $organizationTypes = OrganizationType::all();
        $teamSizes = TeamSize::all();
        $coutries = Country::all();
        $states =
            State::select(['id', 'name', 'country_id'])->where('country_id', $companyInfo?->country)->get();
        $cities =
            City::select(['id', 'name', 'state_id', 'country_id'])->where('state_id', $companyInfo?->state)->get();
        return view('frontend.company-dashboard.profile.index', compact('companyInfo', 'industryTypes', 'organizationTypes', 'teamSizes', 'coutries', 'states', 'cities'));
    }

    function updateCompanyInfo(CompanyInfoUpdateRequest $request): RedirectResponse
    {

        $logoPath = $this->uploadFile($request, 'logo');
        $bannerPath = $this->uploadFile($request, 'banner');
        // dd($logoPath);

        $data = [];
        if (!empty($logoPath)) $data['logo'] = $logoPath;
        if (!empty($bannerPath)) $data['banner'] = $bannerPath;
        $data['name'] = $request->name;
        $data['bio'] = $request->bio;
        $data['vision'] = $request->vision;

        Company::updateOrCreate(
            ['user_id' => auth()->user()->id],
            $data
        );
        if (isCompanyProfileComplete()) {
            $companyProfile = Company::where('user_id', auth()->user()->id)->first();
            $companyProfile->profile_completion = 1;
            $companyProfile->visibility = 1;
            $companyProfile->save();
        }
        Notify::updatedNotification();
        return redirect()->back();
    }
    function updateFoundingInfo(CompanyFoundingInfoUpdateRequest $request): RedirectResponse
    {
        // dd($request->all());
        // dd(isCompanyProfileComplete());
        Company::updateOrCreate(
            ['user_id' => auth()->user()->id],
            [
                'industry_type_id' => $request->industry_type,
                'organization_type_id' => $request->organization_type,
                'team_size_id' => $request->team_size,
                'establishment_date' => $request->establishment_date,
                'website' => $request->website,
                'email' => $request->email,
                'phone' => $request->phone,
                'country' => $request->country,
                'state' => $request->state,
                'city' => $request->city,
                'address' => $request->address,
                'map_link' => $request->map_link,
            ]
        );

        if (isCompanyProfileComplete()) {
            $companyProfile = Company::where('user_id', auth()->user()->id)->first();
            $companyProfile->profile_completion = 1;
            $companyProfile->visibility = 1;
            $companyProfile->save();
        }
        Notify::updatedNotification();

        return redirect()->back();
    }

    function updateAccountInfo(Request $request): RedirectResponse
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email']
        ]);
        Auth::user()->update($validatedData);
        Notify::updatedNotification();
        if (isCompanyProfileComplete()) {
            $companyProfile = Company::where('user_id', auth()->user()->id)->first();
            $companyProfile->profile_completion = 1;
            $companyProfile->visibility = 1;
            $companyProfile->save();
        }

        return redirect()->back();
    }

    function updatePassword(Request $request): RedirectResponse
    {
        // dd($request->all());
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        Auth::user()->update(['password' => bcrypt($request->password)]);
        Notify::updatedNotification();

        return redirect()->back();
    }
}
