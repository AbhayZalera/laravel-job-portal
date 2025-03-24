<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CounterRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'counter_one' => ['required', 'numeric'],
            'title_one' => ['required', 'max:255'],
            'counter_two' => ['required', 'numeric'],
            'title_two' => ['required', 'max:255'],
            'counter_three' => ['required', 'numeric'],
            'title_three' => ['required', 'max:255'],
            'counter_four' => ['required', 'numeric'],
            'title_four' => ['required', 'max:255'],
        ];
    }
}
