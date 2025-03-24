@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Job Roles</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if (!empty($jobRole->id))
                            <h4>Update Job Role</h4>
                        @else
                            <h4>Create New Job Role</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ isset($jobRole->id) ? route('admin.job-roles.update', $jobRole->id) : route('admin.job-roles.store') }}"
                            method="POST">
                            @csrf
                            @if (!empty($jobRole->id))
                                @method('PUT')
                            @endif
                            <div class="form-group">
                                <label for="">Name</label>
                                <input class="form-control {{ hasError($errors, 'name') }}"
                                    value="{{ old('name', $jobRole->name ?? '') }}" type="text" name="name">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    @if (!empty($jobRole->id))
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
