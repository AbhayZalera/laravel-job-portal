@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Social Icons</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if (!empty($icon))
                            <h4>Update Social Icons</h4>
                        @else
                            <h4>Create Social Icons</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ isset($icon->id) ? route('admin.social-icon.update', $icon->id) : route('admin.social-icon.store') }}"
                            method="POST">
                            @csrf
                            @if (!empty($icon->id))
                                @method('PUT')
                            @endif
                            <div class="form-group">
                                <label for="">Icon</label>
                                <div role="iconpicker" data-align="left" name="icon" data-icon="{{ $icon->icon ?? '' }}"
                                    class="{{ hasError($errors, 'icon') }}"></div>
                                <x-input-error :messages="$errors->get('icon')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <label for="">Url</label>
                                <input type="text" class="form-control {{ hasError($errors, 'url') }}" name="url"
                                    value="{{ old('url', isset($icon) ? $icon->url : '') }}">
                                <x-input-error :messages="$errors->get('url')" class="mt-2" />
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    @if (!empty($icon->id))
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
