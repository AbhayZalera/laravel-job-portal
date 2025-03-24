<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WhyChooseUSRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'icon_one' => ['nullable', 'max:255'],
            'title_one' => ['nullable', 'max:255'],
            'sub_title_one' => ['nullable', 'max:255'],
            'icon_two' => ['nullable', 'max:255'],
            'title_two' => ['nullable', 'max:255'],
            'sub_title_two' => ['nullable', 'max:255'],
            'icon_three' => ['nullable', 'max:255'],
            'title_three' => ['nullable', 'max:255'],
            'sub_title_three' => ['nullable', 'max:255'],
        ];
    }
}
