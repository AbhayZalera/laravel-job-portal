@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Languege</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if (!empty($languages->id))
                            <h4>Update Language</h4>
                        @else
                            <h4>Create Language</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ isset($languages) ? route('admin.languages.update', $languages->id) : route('admin.languages.store') }}"
                            method="POST">
                            @csrf
                            @if (!empty($languages->id))
                                @method('PUT')
                            @endif
                            <div class="form-group">
                                <label for="">Name</label>
                                <input class="form-control {{ hasError($errors, 'name') }}"
                                    value="{{ old('name', $languages->name ?? '') }}" type="text" name="name">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    @if (!empty($languages->id))
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
