@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Blogs</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if (!empty($blog->id))
                            <h4>Update Blog</h4>
                        @else
                            <h4>Create Blogs</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ isset($blog->id) ? route('admin.blogs.update', $blog->id) : route('admin.blogs.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (!empty($blog->id))
                                @method('PUT')
                            @endif

                            <div class="form-group">
                                @if (!empty($blog->id))
                                    <x-image-preview :height='200' :width='200' :source="$blog->image" />
                                @endif
                                <label class="font-sm color-text-mutted mb-10">Image *</label>
                                <input class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" type="file"
                                    value="" name="image">
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <label for="">Title</label>
                                <input class="form-control {{ hasError($errors, 'title') }}"
                                    value="{{ old('title', $blog->title ?? '') }}" type="text" name="title">
                                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <label for="">Description <span class="text-danger">*</span> </label>
                                <textarea id="editor" name="description" class="form-control">{{ old('description', $blog->description ?? '') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="">Status</label>
                                <select name="status" class="form-control select2 {{ hasError($errors, 'status') }}">
                                    <option value="1" {{ old('status', $blog->status ?? '') == 1 ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="0" {{ old('status', $blog->status ?? '') == 0 ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <label for="">Featured</label>
                                <select name="featured" class="form-control select2 {{ hasError($errors, 'featured') }}">
                                    <option value="1"
                                        {{ old('featured', $blog->featured ?? '') == 1 ? 'selected' : '' }}>
                                        Yes</option>
                                    <option value="0"
                                        {{ old('featured', $blog->featured ?? '') == 0 ? 'selected' : '' }}>
                                        No</option>
                                </select>
                                <x-input-error :messages="$errors->get('featured')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    @if (!empty($blog->id))
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
