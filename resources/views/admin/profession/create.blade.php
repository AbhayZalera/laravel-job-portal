@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Profession</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if (!empty($profession->id))
                            <h4>Update Professione</h4>
                        @else
                            <h4>Create New Profession</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ isset($profession) ? route('admin.profession.update', $profession->id) : route('admin.profession.store') }}"
                            method="POST">
                            @csrf
                            @if (!empty($profession->id))
                                @method('PUT')
                            @endif
                            <div class="form-group">
                                <label for="">Name</label>
                                <input class="form-control {{ hasError($errors, 'name') }}"
                                    value="{{ old('name', $profession->name ?? '') }}" type="text" name="name"
                                    id="name">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    @if (!empty($profession->id))
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
