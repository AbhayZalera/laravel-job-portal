@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Countries</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if (!empty($countries->id))
                            <h4>Update Country</h4>
                        @else
                            <h4>Create Country</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ isset($countries) ? route('admin.countries.update', $countries->id) : route('admin.countries.store') }}"
                            method="POST">
                            @csrf
                            @if (isset($countries))
                                @method('PUT')
                            @endif
                            <div class="form-group">
                                <label for="">Name</label>
                                <input class="form-control {{ hasError($errors, 'name') }}"
                                    value="{{ old('name', $countries->name ?? '') }}" type="text" name="name"
                                    id="name">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    @if (!empty($countries->id))
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
