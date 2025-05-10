<form action="{{ route('admin.phonepe-settings.update') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">PhonePe Status</label>
                <select name="phonepe_status" class="form-control select2 {{ hasError($errors, 'phonepe_status') }}">
                    <option @selected(config('gatewaySettings.phonepe_status') === 'active') value="active">Active</option>
                    <option @selected(config('gatewaySettings.phonepe_status') === 'inactive') value="inactive">Inactive</option>
                </select>
                <x-input-error :messages="$errors->get('phonepe_status')" class="mt-2" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="">PhonePe Mode</label>
                <select name="phonepe_mode" class="form-control select2 {{ hasError($errors, 'phonepe_mode') }}">
                    <option @selected(config('gatewaySettings.phonepe_mode') === 'sandbox') value="sandbox">Sandbox</option>
                    <option @selected(config('gatewaySettings.phonepe_mode') === 'production') value="production">Production</option>
                </select>
                <x-input-error :messages="$errors->get('phonepe_mode')" class="mt-2" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="">Merchant ID</label>
                <input type="text" class="form-control {{ hasError($errors, 'phonepe_merchant_id') }}"
                    name="phonepe_merchant_id"
                    value="{{ old('phonepe_merchant_id', config('gatewaySettings.phonepe_merchant_id')) }}">
                <x-input-error :messages="$errors->get('phonepe_merchant_id')" class="mt-2" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="">Salt Key</label>
                <input type="text" class="form-control {{ hasError($errors, 'phonepe_salt_key') }}"
                    name="phonepe_salt_key"
                    value="{{ old('phonepe_salt_key', config('gatewaySettings.phonepe_salt_key')) }}">
                <x-input-error :messages="$errors->get('phonepe_salt_key')" class="mt-2" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="">Salt Index</label>
                <input type="text" class="form-control {{ hasError($errors, 'phonepe_salt_index') }}"
                    name="phonepe_salt_index"
                    value="{{ old('phonepe_salt_index', config('gatewaySettings.phonepe_salt_index')) }}">
                <x-input-error :messages="$errors->get('phonepe_salt_index')" class="mt-2" />
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="">PhonePe Currency Rate</label>
                <input type="text" class="form-control {{ hasError($errors, 'phonepe_currency_rate') }}"
                    name="phonepe_currency_rate"
                    value="{{ old('phonepe_currency_rate', config('gatewaySettings.phonepe_currency_rate')) }}">
                <x-input-error :messages="$errors->get('phonepe_currency_rate')" class="mt-2" />
            </div>
        </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>
