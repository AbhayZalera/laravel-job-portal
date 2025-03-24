@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Organization Type</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if (!empty($organizationType->id))
                            <h4>Update Organization Type</h4>
                        @else
                            <h4>Create Organization Type</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ isset($organizationType) ? route('admin.organization-type.update', $organizationType->id) : route('admin.organization-type.store') }}"
                            method="POST">
                            @csrf
                            @if (isset($organizationType))
                                @method('PUT')
                            @endif
                            <div class="form-group">
                                <label for="">Name</label>
                                <input class="form-control {{ hasError($errors, 'name') }}"
                                    value="{{ old('name', $organizationType->name ?? '') }}" type="text" name="name"
                                    placeholder="Enter Nam
                                    type="text" name="name">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    @if (!empty($organizationType->id))
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
