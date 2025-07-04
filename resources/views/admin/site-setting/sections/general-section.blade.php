<div class="tab-pane fade show active" id="home4" role="tabpanel" aria-labelledby="home-tab4">
    <form action="{{ route('admin.general-settings.update') }}" method="POST">
        {{--
            paypal status
            paypal mode
            paypal country
            paypal currency name
            paypal currenncy rate
            paypal client id
            --}}
        @csrf
        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Site Name</label>
                    <input type="text" class="form-control {{ hasError($errors, 'site_name') }}" name="site_name"
                        value="{{ old('site_name', config('settings.site_name')) }}">
                    <x-input-error :messages="$errors->get('site_name')" class="mt-2" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Site Email</label>
                    <input type="text" class="form-control {{ hasError($errors, 'site_email') }}" name="site_email"
                        value="{{ old('site_email', config('settings.site_email')) }}">
                    <x-input-error :messages="$errors->get('site_email')" class="mt-2" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Site Phone</label>
                    <input type="text" class="form-control {{ hasError($errors, 'site_phone') }}" name="site_phone"
                        value="{{ old('site_phone', config('settings.site_phone')) }}">
                    <x-input-error :messages="$errors->get('site_phone')" class="mt-2" />
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="">Site Map</label>
                    <input type="text" class="form-control {{ hasError($errors, 'site_map') }}" name="site_map"
                        value="{{ old('site_map', config('settings.site_map')) }}">
                    <x-input-error :messages="$errors->get('site_map')" class="mt-2" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Site Default Currency</label>
                    <select name="site_default_currency"
                        class="form-control select2 {{ hasError($errors, 'site_default_currency') }}">
                        <option value="">Select Currency</option>
                        @foreach (config('currencies.currency_list') as $key => $currency)
                            <option @selected($currency === config('settings.site_default_currency')) value="{{ $currency }}">{{ $currency }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('site_default_currency')" class="mt-2" />
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Currency Icon</label>
                    <input type="text" class="form-control {{ hasError($errors, 'site_currency_icon') }}"
                        name="site_currency_icon"
                        value="{{ old('site_currency_icon', config('settings.site_currency_icon')) }}">
                    <x-input-error :messages="$errors->get('site_currency_icon')" class="mt-2" />
                </div>
            </div>

        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
</div>
