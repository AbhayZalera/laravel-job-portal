@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>{{ isset($job) ? 'Update Job Post' : 'Create Job Post' }}</h1>
        </div>

        <div class="section-body">
            @foreach ($errors->all() as $error)
                <div class="text-danger">{{ $error }}</div>
            @endforeach
            <div class="col-12">
                <div class="card-body">
                    <form id="job-form"
                        action="{{ isset($job) ? route('admin.jobs.update', $job->id) : route('admin.jobs.store') }}"
                        method="POST">
                        @csrf
                        @if (isset($job))
                            @method('PUT')
                        @endif
                        <div class="card">
                            <div class="card-header">
                                Job Details
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Title <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control {{ hasError($errors, 'title') }}"
                                                name="title" value="{{ old('title', $job->title ?? '') }}">
                                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Select Company <span class="text-danger">*</span></label>
                                            <select name="company"
                                                class="form-control select2 {{ hasError($errors, 'company') }}">
                                                <option value="">Choose</option>
                                                @foreach ($companies as $company)
                                                    <option @selected((isset($job) && $company->id === $job->company_id) || old('company') == $company->id) value="{{ $company->id }}">
                                                        {{ $company->name }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error :messages="$errors->get('company')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Category <span class="text-danger">*</span></label>
                                            <select name="category"
                                                class="form-control select2 {{ hasError($errors, 'category') }}">
                                                <option value="">Choose</option>
                                                @foreach ($categories as $category)
                                                    <option @selected((isset($job) && $category->id === $job->job_category_id) || old('category') == $category->id) value="{{ $category->id }}">
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Total Vacancies <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control {{ hasError($errors, 'vacancies') }}"
                                                name="vacancies" value="{{ old('vacancies', $job->vacancies ?? '') }}">
                                            <x-input-error :messages="$errors->get('vacancies')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Deadline <span class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control datepicker {{ hasError($errors, 'deadline') }}"
                                                name="deadline" value="{{ old('deadline', $job->deadline ?? '') }}">
                                            <x-input-error :messages="$errors->get('deadline')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Location Section -->
                        <div class="card">
                            <div class="card-header">
                                Location
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Country</label>
                                            <select name="country"
                                                class="form-control select2 country {{ hasError($errors, 'country') }}">
                                                <option value="">Choose</option>
                                                @foreach ($countries as $country)
                                                    <option @selected((isset($job) && $country->id === $job->country_id) || old('country') == $country->id) value="{{ $country->id }}">
                                                        {{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error :messages="$errors->get('country')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">State</label>
                                            <select name="state"
                                                class="form-control select2 state {{ hasError($errors, 'state') }}">
                                                <option value="">Choose</option>
                                                @if (!empty($job))
                                                    @foreach ($states as $state)
                                                        <option @selected((isset($job) && $state->id === $job->state_id) || old('state') == $state->id) value="{{ $state->id }}">
                                                            {{ $state->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <x-input-error :messages="$errors->get('state')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">City</label>
                                            <select name="city"
                                                class="form-control select2 city {{ hasError($errors, 'city') }}">
                                                <option value="">Choose</option>
                                                @if (!empty($job))
                                                    @foreach ($cities as $city)
                                                        <option @selected((isset($job) && $city->id === $job->city_id) || old('city') == $city->id) value="{{ $city->id }}">
                                                            {{ $city->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <x-input-error :messages="$errors->get('city')" class="mt-2" />
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Address</label>
                                            <input type="text" class="form-control {{ hasError($errors, 'address') }}"
                                                name="address" value="{{ old('address', $job->address ?? '') }}">
                                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Salary Details Section -->
                        <div class="card">
                            <div class="card-header">
                                Salary Details
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <input @checked((isset($job) && $job->salary_mode === 'range') || old('salary_mode') == 'range')
                                                        onclick="salaryModeChange('salary_range')" type="radio"
                                                        id="salary_range"
                                                        class="from-control {{ hasError($errors, 'salary_mode') }}"
                                                        name="salary_mode" value="range" checked>
                                                    <label for="salary_range">Salary Range</label>
                                                    <x-input-error :messages="$errors->get('salary_mode')" class="mt-2" />
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <input @checked((isset($job) && $job->salary_mode === 'custom') || old('salary_mode') == 'custom')
                                                        onclick="salaryModeChange('custom_salary')" type="radio"
                                                        id="custom_salary"
                                                        class="from-control {{ hasError($errors, 'salary_mode') }}"
                                                        name="salary_mode" value="custom">
                                                    <label for="custom_salary">Custom Salary</label>
                                                    <x-input-error :messages="$errors->get('salary_mode')" class="mt-2" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @if (!empty($job))
                                        @if ($job->salary_mode === 'range')
                                            <div class="col-md-12 salary_range_part">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Minimum Salary <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text"
                                                                class="form-control {{ hasError($errors, 'min_salary') }}"
                                                                name="min_salary"
                                                                value="{{ old('min_salary', $job->min_salary ?? '') }}">
                                                            <x-input-error :messages="$errors->get('min_salary')" class="mt-2" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Maximum Salary <span
                                                                    class="text-danger">*</span></label>
                                                            <input type="text"
                                                                class="form-control {{ hasError($errors, 'max_salary') }}"
                                                                name="max_salary"
                                                                value="{{ old('max_salary', $job->max_salary ?? '') }}">
                                                            <x-input-error :messages="$errors->get('max_salary')" class="mt-2" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif ($job->salary_mode === 'custom')
                                            <div class="col-md-12 custom_salary_part">
                                                <div class="form-group">
                                                    <label for="">Custom Salary <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control {{ hasError($errors, 'custom_salary') }}"
                                                        name="custom_salary"
                                                        value="{{ old('custom_salary', $job->custom_salary ?? '') }}">
                                                    <x-input-error :messages="$errors->get('custom_salary')" class="mt-2" />
                                                </div>
                                            </div>
                                        @else
                                            <td>Something Went Wrong</td>
                                        @endif
                                    @else
                                        <div class="col-md-12 salary_range_part">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Minimum Salary <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control {{ hasError($errors, 'min_salary') }}"
                                                            name="min_salary"
                                                            value="{{ old('min_salary', $job->min_salary ?? '') }}">
                                                        <x-input-error :messages="$errors->get('min_salary')" class="mt-2" />
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Maximum Salary <span
                                                                class="text-danger">*</span></label>
                                                        <input type="text"
                                                            class="form-control {{ hasError($errors, 'max_salary') }}"
                                                            name="max_salary"
                                                            value="{{ old('max_salary', $job->max_salary ?? '') }}">
                                                        <x-input-error :messages="$errors->get('max_salary')" class="mt-2" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 custom_salary_part d-none">
                                            <div class="form-group">
                                                <label for="">Custom Salary <span
                                                        class="text-danger">*</span></label>
                                                <input type="text"
                                                    class="form-control {{ hasError($errors, 'custom_salary') }}"
                                                    name="custom_salary"
                                                    value="{{ old('custom_salary', $job->custom_salary ?? '') }}">
                                                <x-input-error :messages="$errors->get('custom_salary')" class="mt-2" />
                                            </div>
                                        </div>
                                    @endif


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Salary Type <span class="text-danger">*</span></label>
                                            <select name="salary_type"
                                                class="form-control select2 {{ hasError($errors, 'salary_type') }}">
                                                <option value="">Choose</option>
                                                @foreach ($salaryTypes as $salaryType)
                                                    <option @selected((isset($job) && $job->salary_type_id === $salaryType->id) || old('salary_type') == $salaryType->id) value="{{ $salaryType->id }}">
                                                        {{ $salaryType->name }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error :messages="$errors->get('salary_type')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Attributes Section -->
                        <div class="card">
                            <div class="card-header">
                                Attributes
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Experience <span class="text-danger">*</span></label>
                                            <select name="experience"
                                                class="form-control select2 {{ hasError($errors, 'experience') }}">
                                                <option value="">Choose</option>
                                                @foreach ($experiences as $experience)
                                                    <option @selected((isset($job) && $job->job_experience_id === $experience->id) || old('experience') == $experience->id) value="{{ $experience->id }}">
                                                        {{ $experience->name }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error :messages="$errors->get('experience')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Job Role <span class="text-danger">*</span></label>
                                            <select name="job_role"
                                                class="form-control select2 {{ hasError($errors, 'job_role') }}">
                                                <option value="">Choose</option>
                                                @foreach ($jobRoles as $role)
                                                    <option @selected((isset($job) && $job->job_role_id === $role->id) || old('job_role') == $role->id) value="{{ $role->id }}">
                                                        {{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error :messages="$errors->get('job_role')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Education <span class="text-danger">*</span></label>
                                            <select name="education"
                                                class="form-control select2 {{ hasError($errors, 'education') }}">
                                                <option value="">Choose</option>
                                                @foreach ($educations as $education)
                                                    <option @selected((isset($job) && $job->education_id === $education->id) || old('education') == $education->id) value="{{ $education->id }}">
                                                        {{ $education->name }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error :messages="$errors->get('education')" class="mt-2" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Job Type <span class="text-danger">*</span></label>
                                            <select name="job_type"
                                                class="form-control select2 {{ hasError($errors, 'job_type') }}">
                                                <option value="">Choose</option>
                                                @foreach ($jobTypes as $jobType)
                                                    <option @selected((isset($job) && $job->job_type_id === $jobType->id) || old('job_type') == $jobType->id) value="{{ $jobType->id }}">
                                                        {{ $jobType->name }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error :messages="$errors->get('job_type')" class="mt-2" />
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Tags <span class="text-danger">*</span></label>
                                            <select name="tags[]" multiple
                                                class="form-control select2 {{ hasError($errors, 'tags') }}">
                                                @php
                                                    $selectedTags = isset($job)
                                                        ? $job->tags()->pluck('tag_id')->toArray()
                                                        : [];
                                                @endphp
                                                @foreach ($tags as $tag)
                                                    <option @selected(in_array($tag->id, $selectedTags) || in_array($tag->id, old('tags', []))) value="{{ $tag->id }}">
                                                        {{ $tag->name }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error :messages="$errors->get('tags')" class="mt-2" />
                                        </div>
                                    </div>
                                    @if (isset($job))
                                        @php
                                            $benefits = $job->benefits()->with('benefit')->get();
                                            $benefitNames = [];
                                            foreach ($benefits as $benifit) {
                                                $benefitNames[] = $benifit->benefit?->name;
                                            }
                                            $benefitNameString = implode(',', $benefitNames);
                                            // dd($benefitNames);
                                        @endphp
                                    @endif

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Benefits <span class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control inputtags {{ hasError($errors, 'benefits') }}"
                                                name="benefits" value="{{ old('benefits', $benefitNameString ?? '') }}">
                                            <x-input-error :messages="$errors->get('benefits')" class="mt-2" />
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Skills <span class="text-danger">*</span></label>
                                            <select name="skills[]" multiple
                                                class="form-control select2 {{ hasError($errors, 'skills') }}">
                                                @php
                                                    $selectedSkills = isset($job)
                                                        ? $job->skills()->pluck('skill_id')->toArray()
                                                        : [];
                                                @endphp
                                                @foreach ($skills as $skill)
                                                    <option @selected(in_array($skill->id, $selectedSkills) || in_array($skill->id, old('skills', []))) value="{{ $skill->id }}">
                                                        {{ $skill->name }}</option>
                                                @endforeach
                                            </select>
                                            <x-input-error :messages="$errors->get('skills')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Application Options Section -->
                        <div class="card">
                            <div class="card-header">
                                Application Options
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Receive Applications <span
                                                    class="text-danger">*</span></label>
                                            <select name="receive_applications"
                                                class="form-control select2 {{ hasError($errors, 'receive_applications') }}">
                                                <option @selected((isset($job) && $job->apply_on == 'app') || old('receive_applications') == 'app') value="app">On Our Platform
                                                </option>
                                                <option @selected((isset($job) && $job->apply_on == 'email') || old('receive_applications') == 'email') value="email">On your email address
                                                </option>
                                                <option @selected((isset($job) && $job->apply_on == 'custom_url') || old('receive_applications') == 'custom_url') value="custom_url">On a custom link
                                                </option>
                                            </select>
                                            <x-input-error :messages="$errors->get('receive_applications')" class="mt-2" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Promote Section -->
                        <div class="card">
                            <div class="card-header">
                                Promote
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <input @checked((isset($job) && $job->featured) || old('featured')) type="checkbox" id="featured"
                                                        class="from-control {{ hasError($errors, 'featured') }}"
                                                        name="featured" value="1">
                                                    <label for="featured">Featured</label>
                                                    <x-input-error :messages="$errors->get('featured')" class="mt-2" />
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <input @checked((isset($job) && $job->highlight) || old('highlight')) type="checkbox" id="highlight"
                                                        class="from-control {{ hasError($errors, 'highlight') }}"
                                                        name="highlight" value="1">
                                                    <label for="highlight">Highlight</label>
                                                    <x-input-error :messages="$errors->get('highlight')" class="mt-2" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description Section -->
                        <div class="card">
                            <div class="card-header">
                                Description
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Description <span class="text-danger">*</span></label>
                                            <textarea id="editor" name="description">{!! old('description', $job->description ?? '') !!}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                {{ isset($job) ? 'Update' : 'Create' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        $(".inputtags").tagsinput('items');

        function salaryModeChange(mode) {
            if (mode == 'salary_range') {
                $('.salary_range_part').removeClass('d-none');
                $('.custom_salary_part').addClass('d-none');
            } else if (mode == 'custom_salary') {
                $('.salary_range_part').addClass('d-none');
                $('.custom_salary_part').removeClass('d-none');
            }
        }

        $('.country').on('change', function() {
            let country_id = $(this).val();
            // remove all previous cities
            $('.city').html("");

            $.ajax({
                method: 'GET',
                url: '{{ route('get-states', ':id') }}'.replace(":id", country_id),
                data: {},
                success: function(response) {
                    let html = '';

                    $.each(response, function(index, value) {
                        html += `<option value="${value.id}">${value.name}</option>`;
                    });

                    $('.state').html(html);
                },
                error: function(xhr, status, error) {}
            });
        });

        // get cities
        $('.state').on('change', function() {
            let state_id = $(this).val();

            $.ajax({
                method: 'GET',
                url: '{{ route('get-cities', ':id') }}'.replace(":id", state_id),
                data: {},
                success: function(response) {
                    let html = '';

                    $.each(response, function(index, value) {
                        html += `<option value="${value.id}">${value.name}</option>`;
                    });

                    $('.city').html(html);
                },
                error: function(xhr, status, error) {}
            });
        });

        //Store and Update

        $('#job-form').on('submit', function(e) {
            e.preventDefault();

            let form = $(this);
            let url = form.attr('action');
            let method = form.attr('method');
            let formData = new FormData(form[0]);

            $.ajax({
                url: url,
                method: method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {

                    if (response) {
                        swal('Success!', response.message, 'success').then(() => {
                            // window.location.href =
                            //     "{{ route('admin.jobs.index') }}";
                        });
                    } else {
                        swal('Error!', response.message, 'error');
                    }
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = '';
                    $.each(errors, function(key, value) {
                        errorMessages += value[0] + '<br>';
                    });
                    swal('Error!', errorMessages, 'error');
                }
            });
        });
    </script>
@endpush
