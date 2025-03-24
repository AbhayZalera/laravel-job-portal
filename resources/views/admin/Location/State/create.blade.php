@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>States</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if (!empty($states->id))
                            <h4>Update States</h4>
                        @else
                            <h4>Create New States</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ isset($states) ? route('admin.states.update', $states->id) : route('admin.states.store') }}"
                            method="POST">
                            @csrf
                            @if (isset($states))
                                @method('PUT')
                            @endif
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Country</label>
                                        <select name="country" id=""
                                            class="form-control select2 {{ hasError($errors, 'country') }}">
                                            <option value="">Select</option>
                                            @foreach ($countries as $country)
                                                <option @selected(isset($states) && $states->country_id === $country->id) value="{{ $country->id }}">
                                                    {{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('country')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">State Name</label>
                                        <input class="form-control {{ hasError($errors, 'name') }}"
                                            value="{{ old('name', $states->name ?? '') }}" type="text" name="name">
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    @if (!empty($states->id))
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
