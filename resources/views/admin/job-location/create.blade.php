@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Location Section</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    {{-- <div class="card-header">
                        @if (!empty($location->id))
                            <h4>Update Location</h4>
                        @else
                            <h4>Create Location</h4>
                        @endif

                    </div> --}}
                    <div class="card-header">
                        @if (!empty($location->id))
                            <h4>Update Location</h4>
                        @else
                            <h4>Create Location</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ isset($location->id) ? route('admin.job-location.update', $location->id) : route('admin.job-location.store') }}"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            @if (!empty($location->id))
                                @method('PUT')
                            @endif
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        @if (!empty($location->id))
                                            <x-image-preview :height='200' :width='200' :source="$location->image" />
                                        @endif
                                        <label for="">Image</label>
                                        <input type="file" class="form-control {{ hasError($errors, 'image') }}"
                                            name="image">
                                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="">Country</label>
                                <select name="country_id" id=""
                                    class="form-control select2 {{ hasError($errors, 'country_id') }}">
                                    <option value="">choose</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}" @selected(isset($location) && $country->id === $location->country_id)>
                                            {{ $country->name }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('country_id')" class="mt-2" />
                            </div>
                            <div class="form-group">
                                <label for="">Status</label>
                                <select name="status" id=""
                                    class="form-control {{ hasError($errors, 'status') }}">
                                    <option value="">choose</option>
                                    <option @selected(isset($location) && $location->status == 'featured') value="featured">
                                        Featured</option>
                                    <option @selected(isset($location) && $location->status == 'trending') value="trending">Treding
                                    </option>
                                    <option @selected(isset($location) && $location->status == 'hot') value="hot">HOT</option>
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    @if (!empty($location->id))
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
