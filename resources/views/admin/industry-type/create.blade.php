@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Idustry Type</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if (!empty($industryType->id))
                            <h4>Update Industry Type</h4>
                        @else
                            <h4>Create Industry Type</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ isset($industryType->id) ? route('admin.industry-type.update', $industryType->id) : route('admin.industry-type.store') }}"
                            method="POST">
                            @csrf
                            @if (!empty($industryType->id))
                                @method('PUT')
                            @endif
                            <div class="form-group">
                                <label for="">Name</label>
                                <input class="form-control {{ hasError($errors, 'name') }}"
                                    value="{{ old('name', $industryType->name ?? '') }}" type="text" name="name"
                                    placeholder="Enter Name" type="text" name="name">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    @if (!empty($industryType->id))
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
