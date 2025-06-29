<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobLocationCreateRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => ['required', 'image', 'max:3000'],
            'country_id' => ['required', 'numeric'],
            'status' => ['required']
        ];
    }
}
