<form action="{{ route('admin.paypal-settings.update') }}" method="POST">
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

        <div class="col-md-6">
            <div class="form-group">
                <label for="">Paypal Status</label>
                <select name="paypal_status" class="form-control select2 {{ hasError($errors, 'paypal_status') }}">
                    <option @selected(config('gatewaySettings.paypal_status') === 'active') value="active">Active</option>
                    <option @selected(config('gatewaySettings.paypal_status') === 'inactive') value="inactive">Inactive</option>
                </select>
                <x-input-error :messages="$errors->get('paypal_status')" class="mt-2" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="">Paypal Account Mode</label>
                <select name="paypal_acoount_mode"
                    class="form-control select2 {{ hasError($errors, 'paypal_acoount_mode') }}">
                    <option @selected(config('gatewaySettings.paypal_acoount_mode') === 'sandbox') value="sandbox">Sandbox</option>
                    <option @selected(config('gatewaySettings.paypal_acoount_mode') === 'live') value="live">Live</option>
                </select>
                <x-input-error :messages="$errors->get('paypal_acoount_mode')" class="mt-2" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="">Paypal Country Name</label>
                <select name="paypal_country_name"
                    class="form-control select2 {{ hasError($errors, 'paypal_country_name') }}">
                    <option value="">Select Country</option>
                    @foreach (config('countries') as $key => $country)
                        <option @selected($key === config('gatewaySettings.paypal_country_name')) value="{{ $key }}">{{ $country }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('paypal_country_name')" class="mt-2" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="">Paypal Currency Name</label>
                <select name="paypal_currency_name"
                    class="form-control select2 {{ hasError($errors, 'paypal_currency_name') }}">
                    <option value="">Select Currency</option>
                    @foreach (config('currencies.currency_list') as $key => $currency)
                        <option @selected($currency === config('gatewaySettings.paypal_currency_name')) value="{{ $currency }}">{{ $currency }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('paypal_currency_name')" class="mt-2" />
            </div>
        </div>


        <div class="col-md-12">
            <div class="form-group">
                <label for="">Paypal Currency Rate</label>
                <input type="text" class="form-control {{ hasError($errors, 'paypal_currency_rate') }}"
                    name="paypal_currency_rate"
                    value="{{ old('paypal_currency_rate', config('gatewaySettings.paypal_currency_rate')) }}">
                <x-input-error :messages="$errors->get('paypal_currency_rate')" class="mt-2" />
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="">Paypal Client Id</label>
                <input type="text" class="form-control {{ hasError($errors, 'paypal_client_id') }}"
                    name="paypal_client_id"
                    value="{{ old('paypal_client_id', config('gatewaySettings.paypal_client_id')) }}">
                <x-input-error :messages="$errors->get('paypal_client_id')" class="mt-2" />
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="">Paypal Secret Key</label>
                <input type="text" class="form-control {{ hasError($errors, 'paypal_client_secret') }}"
                    name="paypal_client_secret"
                    value="{{ old('paypal_client_secret', config('gatewaySettings.paypal_client_secret')) }}">
                <x-input-error :messages="$errors->get('paypal_client_secret')" class="mt-2" />
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="">Paypal App Id</label>
                <input type="text" class="form-control {{ hasError($errors, 'paypal_app_id') }}"
                    name="paypal_app_id" value="{{ old('paypal_app_id', config('gatewaySettings.paypal_app_id')) }}">
                <x-input-error :messages="$errors->get('paypal_app_id')" class="mt-2" />
            </div>
        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>
