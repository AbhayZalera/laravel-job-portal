<form action="{{ route('admin.stripe-settings.update') }}" method="POST">
    @csrf
    <div class="row">

        <div class="col-md-12">
            <div class="form-group">
                <label for="">Stripe Status</label>
                <select name="stripe_status" class="form-control select2 {{ hasError($errors, 'stripe_status') }}">
                    <option @selected(config('gatewaySettings.stripe_status') === 'active') value="active">Active</option>
                    <option @selected(config('gatewaySettings.stripe_status') === 'inactive') value="inactive">Inactive</option>
                </select>
                <x-input-error :messages="$errors->get('stripe_status')" class="mt-2" />
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
                <label for="">Stripe Country Name</label>
                <select name="stripe_country_name"
                    class="form-control select2 {{ hasError($errors, 'stripe_country_name') }}">
                    <option value="">Select Country</option>
                    @foreach (config('countries') as $key => $country)
                        <option @selected($key === config('gatewaySettings.stripe_country_name')) value="{{ $key }}">{{ $country }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('stripe_country_name')" class="mt-2" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="">Stripe Currency Name</label>
                <select name="stripe_currency_name"
                    class="form-control select2 {{ hasError($errors, 'stripe_currency_name') }}">
                    <option value="">Select Currency</option>
                    @foreach (config('currencies.currency_list') as $key => $currency)
                        <option @selected($currency === config('gatewaySettings.stripe_currency_name')) value="{{ $currency }}">{{ $currency }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('stripe_currency_name')" class="mt-2" />
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="">Stripe Currency Rate</label>
                <input type="text" class="form-control {{ hasError($errors, 'stripe_currency_rate') }}"
                    name="stripe_currency_rate"
                    value="{{ old('stripe_currency_rate', config('gatewaySettings.stripe_currency_rate')) }}">
                <x-input-error :messages="$errors->get('stripe_currency_rate')" class="mt-2" />
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="">Stripe Publishable key</label>
                <input type="text" class="form-control {{ hasError($errors, 'stripe_publishable_key') }}"
                    name="stripe_publishable_key"
                    value="{{ old('paypal_client_id', config('gatewaySettings.stripe_publishable_key')) }}">
                <x-input-error :messages="$errors->get('stripe_publishable_key')" class="mt-2" />
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="">Stripe Secret Key</label>
                <input type="text" class="form-control {{ hasError($errors, 'stripe_client_secret') }}"
                    name="stripe_client_secret"
                    value="{{ old('stripe_client_secret', config('gatewaySettings.stripe_client_secret')) }}">
                <x-input-error :messages="$errors->get('stripe_client_secret')" class="mt-2" />
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </div>
</form>
