<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PhonepeSettingUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phonepe_status' => ['required', 'in:active,inactive'],
            'phonepe_mode' => ['required', 'in:sandbox,production'],
            'phonepe_merchant_id' => ['required', 'string'],
            'phonepe_salt_key' => ['required', 'string'],
            'phonepe_salt_index' => ['required', 'string'],
            'phonepe_currency_rate' => ['required', 'numeric'],
        ];
    }
}
