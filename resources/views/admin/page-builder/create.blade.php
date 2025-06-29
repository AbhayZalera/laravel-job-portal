@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Page Builder</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if (!empty($page->id))
                            <h4>Update Page</h4>
                        @else
                            <h4>Create Page</h4>
                        @endif

                    </div>
                    <div class="card-body">
                        <form
                            action="{{ isset($page->id) ? route('admin.page-builder.update', $page->id) : route('admin.page-builder.store') }}"
                            method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="">Page Name</label>
                                <input type="text" class="form-control {{ hasError($errors, 'page_name') }}"
                                    name="page_name" value="{{ old('page_name', $page->page_name ?? '') }}">
                                <x-input-error :messages="$errors->get('page_name')" class="mt-2" />
                            </div>
                            <div class="form-group">
                                <label for="">Content</label>
                                <textarea name="content" id="editor" class="{{ hasError($errors, 'content') }}"> {!! $page->content ?? '' !!}</textarea>
                                <x-input-error :messages="$errors->get('content')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    @if (!empty($page->id))
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
