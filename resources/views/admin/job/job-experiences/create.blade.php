@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Job Experiences</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if (!empty($jobExperience->id))
                            <h4>Update Job Experience</h4>
                        @else
                            <h4>Create New Job Experience</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ isset($jobExperience) ? route('admin.job-experiences.update', $jobExperience->id) : route('admin.job-experiences.store') }}"
                            method="POST">
                            @csrf
                            @if (isset($jobExperience))
                                @method('PUT')
                            @endif
                            <div class="form-group">
                                <label for="">Name</label>
                                <input class="form-control {{ hasError($errors, 'name') }}"
                                    value="{{ old('name', $jobExperience->name ?? '') }}" type="text" name="name"
                                    id="name">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    @if (!empty($jobExperience->id))
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
