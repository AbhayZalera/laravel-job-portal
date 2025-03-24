@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Job Category</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if (!empty($category->id))
                            <h4>Update Job Category</h4>
                        @else
                            <h4>Create Job Category</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ isset($category->id) ? route('admin.job-categories.update', $category->id) : route('admin.job-categories.store') }}"
                            method="POST">
                            @csrf
                            @if (!empty($category->id))
                                @method('PUT')
                            @endif
                            <div class="form-group">
                                <label for="">Icon</label>
                                <div role="iconpicker" data-align="left" name='icon'
                                    data-icon='{{ $category->icon ?? '' }}' class="{{ hasError($errors, 'icon') }}"></div>
                                <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <label for="">Name</label>
                                <input class="form-control {{ hasError($errors, 'name') }}"
                                    value="{{ old('name', $category->name ?? '') }}" type="text" name="name">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <label for="">Show At Popular</label>
                                <select class="form-control {{ hasError($errors, 'show_at_popular') }}"
                                    name="show_at_popular">
                                    <option @selected(isset($category->id) && $category->show_at_popular === 0) value="0">No</option>
                                    <option @selected(isset($category->id) && $category->show_at_popular === 1) value="1">Yes</option>
                                </select>
                                <x-input-error :messages="$errors->get('show_at_popular')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <label for="">Show At Featured</label>
                                <select class="form-control {{ hasError($errors, 'show_at_featured') }}"
                                    name="show_at_featured">
                                    <option @selected(isset($category->id) && $category->show_at_featured === 0) value="0">No</option>
                                    <option @selected(isset($category->id) && $category->show_at_featured === 1) value="1">Yes</option>
                                </select>
                                <x-input-error :messages="$errors->get('show_at_featured')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    @if (!empty($category->id))
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
