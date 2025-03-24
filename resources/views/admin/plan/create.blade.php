@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Create Plan</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if (!empty($plan->id))
                            <h4>Update Plan</h4>
                        @else
                            <h4>Create Plan</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ isset($plan) ? route('admin.plans.update', $plan->id) : route('admin.plans.store') }}"
                            method="POST">
                            @csrf
                            @if (isset($plan))
                                @method('PUT')
                            @endif
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Label</label>
                                        <input class="form-control {{ hasError($errors, 'label') }}"
                                            value="{{ old('label', $plan->label ?? '') }}" type="text" name="label">
                                        <x-input-error :messages="$errors->get('label')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Price</label>
                                        <input class="form-control {{ hasError($errors, 'price') }}"
                                            value="{{ old('price', $plan->price ?? '') }}" type="text" name="price">
                                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Job Limit</label>
                                        <input class="form-control {{ hasError($errors, 'job_limit') }}"
                                            value="{{ old('job_limit', $plan->job_limit ?? '') }}" type="text"
                                            name="job_limit">
                                        <x-input-error :messages="$errors->get('job_limit')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Featured Job Limit</label>
                                        <input class="form-control {{ hasError($errors, 'featured_job_limit') }}"
                                            value="{{ old('featured_job_limit', $plan->featured_job_limit ?? '') }}"
                                            type="text" name="featured_job_limit">
                                        <x-input-error :messages="$errors->get('featured_job_limit')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Highlight Job Limit</label>
                                        <input class="form-control {{ hasError($errors, 'highlight_job_limit') }}"
                                            value="{{ old('highlight_job_limit', $plan->highlight_job_limit ?? '    ') }}"
                                            type="text" name="highlight_job_limit">
                                        <x-input-error :messages="$errors->get('highlight_job_limit')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Profile Verified</label>
                                        <select name="profile_verified" id=""
                                            class="form-control {{ hasError($errors, 'profile_verified') }}">
                                            <option @selected(isset($plan) && $plan->profile_verified === 1) value="1">Yes</option>
                                            <option @selected(isset($plan) && $plan->profile_verified === 0) value="0">No</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('profile_verified')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Recommended</label>
                                        <select name="recommended" id=""
                                            class="form-control {{ hasError($errors, 'recommended') }}">
                                            <option @selected(isset($plan) && $plan->recommended === 1) value="1">Yes</option>
                                            <option @selected(isset($plan) && $plan->recommended === 0) value="0">No</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('recommended')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Show this Package in Frontend</label>
                                        <select name="frontend_show" id=""
                                            class="form-control {{ hasError($errors, 'frontend_show') }}">
                                            <option @selected(isset($plan) && $plan->frontend_show === 1) value="1">Yes</option>
                                            <option @selected(isset($plan) && $plan->frontend_show === 0) value="0">No</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('frontend_show')" class="mt-2" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Show this Package in Home</label>
                                        <select name="show_at_home" id=""
                                            class="form-control {{ hasError($errors, 'show_at_home') }}">
                                            <option @selected(isset($plan) && $plan->show_at_home === 1) value="1">Yes</option>
                                            <option @selected(isset($plan) && $plan->show_at_home === 0) value="0">No</option>
                                        </select>
                                        <x-input-error :messages="$errors->get('show_at_home')" class="mt-2" />
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    @if (!empty($plan->id))
                                        Update
                                    @else
                                        Create
                                    @endif
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
