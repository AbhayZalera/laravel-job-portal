@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Educations</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">

                        @if (!empty($education->id))
                            <h4>Update Education</h4>
                        @else
                            <h4>Create New Education</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ isset($education) ? route('admin.educations.update', $education->id) : route('admin.educations.store') }}"
                            method="POST">
                            @csrf
                            @if (isset($education))
                                @method('PUT')
                            @endif
                            <div class="form-group">
                                <label for="">Name</label>
                                <input class="form-control {{ hasError($errors, 'name') }}"
                                    value="{{ old('name', $education->name ?? '') }}" type="text" name="name">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    @if (!empty($education->id))
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
