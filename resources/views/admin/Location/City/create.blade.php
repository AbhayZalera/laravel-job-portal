@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <h1>Cities</h1>
        </div>

        <div class="section-body">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if (!empty($cities->id))
                            <h4>Update Cities</h4>
                        @else
                            <h4>Create Cities</h4>
                        @endif
                    </div>
                    <div class="card-body">
                        <form
                            action="{{ isset($cities) ? route('admin.cities.update', $cities->id) : route('admin.cities.store') }}"
                            method="POST">
                            @csrf
                            @if (isset($cities))
                                @method('PUT')
                            @endif
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Country</label>
                                        <select name="country" id=""
                                            class="form-control select2 country {{ hasError($errors, 'country') }}">
                                            <option value="">Select</option>
                                            @foreach ($countries as $country)
                                                <option @selected(isset($cities) && $cities->country_id === $country->id) value="{{ $country->id }}">
                                                    {{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('country')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">State</label>
                                        <select name="state" id=""
                                            class="form-control select2 state {{ hasError($errors, 'state') }}">
                                            <option value="">Select</option>
                                            @foreach ($states as $state)
                                                <option @selected(isset($cities) && $state->id === $cities->state_id) value="{{ $state->id }}">
                                                    {{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                        <x-input-error :messages="$errors->get('state')" class="mt-2" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">City Name</label>
                                        <input class="form-control {{ hasError($errors, 'name') }}"
                                            value="{{ old('name', $cities->name ?? '') }}" type="text" name="name">
                                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    @if (!empty($cities->id))
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
@push('script')
    <script>
        $(document).ready(function() {
            $('.country').on('change', function() {
                let country_id = $(this).val();

                $.ajax({
                    method: "GET",
                    url: "{{ route('admin.get_states', ':id') }}".replace(":id", country_id),
                    data: {},
                    success: function(response) {
                        let html = '';
                        $.each(response, function(index, value) {
                            // console.log(value);
                            html += `<option value="${value.id}">${value.name}</option>`
                        });
                        $('.state').html(html);
                    },
                    error: function(xhr, status, error) {

                    }
                });

            });
        });
    </script>
@endpush
