<form action="{{ route('admin.razorpay-settings.update') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="">Razorpay Status</label>
                <select name="razorpay_status" class="form-control select2 {{ hasError($errors, 'razorpay_status') }}">
                    <option @selected(config('gatewaySettings.razorpay_status') === 'active') value="active">Active</option>
                    <option @selected(config('gatewaySettings.razorpay_status') === 'inactive') value="inactive">Inactive</option>
                </select>
                <x-input-error :messages="$errors->get('razorpay_status')" class="mt-2" />
            </div>
        </div>

        {{-- <div class="col-md-6">
                <div class="form-group">
                    <label for="">Paypal Account Mode</label>
                    <select name="stripe_acoount_mode"
                        class="form-control select2 {{ hasError($errors, 'stripe_acoount_mode') }}">
                        <option @selected(config('gatewaySettings.stripe_acoount_mode') === 'sandbox') value="sandbox">Sandbox</option>
                        <option @selected(config('gatewaySettings.stripe_acoount_mode') === 'live') value="live">Live</option>
                    </select>
                    <x-input-error :messages="$errors->get('stripe_acoount_mode')" class="mt-2" />
                </div>
            </div> --}}

        <div class="col-md-6">
            <div class="form-group">
                <label for="">Razorpay Country Name</label>
                <select name="razorpay_country_name"
                    class="form-control select2 {{ hasError($errors, 'razorpay_country_name') }}">
                    <option value="">Select Country</option>
                    @foreach (config('countries') as $key => $country)
                        <option @selected($key === config('gatewaySettings.razorpay_country_name')) value="{{ $key }}">{{ $country }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('razorpay_country_name')" class="mt-2" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="">Razorpay Currency Name</label>
                <select name="razorpay_currency_name"
                    class="form-control select2 {{ hasError($errors, 'razorpay_currency_name') }}">
                    <option value="">Select Currency</option>
                    @foreach (config('currencies.currency_list') as $key => $currency)
                        <option @selected($currency === config('gatewaySettings.razorpay_currency_name')) value="{{ $currency }}">{{ $currency }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('razorpay_currency_name')" class="mt-2" />
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="">Razorpay Currency Rate</label>
                <input type="text" class="form-control {{ hasError($errors, 'razorpay_currency_rate') }}"
                    name="razorpay_currency_rate"
                    value="{{ old('razorpay_currency_rate', config('gatewaySettings.razorpay_currency_rate')) }}">
                <x-input-error :messages="$errors->get('razorpay_currency_rate')" class="mt-2" />
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="">Razorpay key</label>
                <input type="text" class="form-control {{ hasError($errors, 'razorpay_key') }}" name="razorpay_key"
                    value="{{ old('razorpay_key', config('gatewaySettings.razorpay_key')) }}">
                <x-input-error :messages="$errors->get('razorpay_key')" class="mt-2" />
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="">Razorpay Secret Key</label>
                <input type="text" class="form-control {{ hasError($errors, 'razorpay_client_secret') }}"
                    name="razorpay_client_secret"
                    value="{{ old('razorpay_client_secret', config('gatewaySettings.razorpay_client_secret')) }}">
                <x-input-error :messages="$errors->get('razorpay_client_secret')" class="mt-2" />
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
</form>
