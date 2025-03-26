<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobApiCreateRequest extends FormRequest
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
            'title' => ['required', 'max:255'],
            'company_id' => ['required', 'integer'],
            'job_category_id' => ['required', 'integer'],
            'vacancies' => ['required', 'max:255'],
            'deadline' => ['required', 'date'],
            'country_id' => ['nullable', 'integer'],
            'state_id' => ['nullable', 'integer'],
            'city_id' => ['nullable', 'integer'],
            'address' => ['nullable', 'max:255'],
            'salary_mode' => ['required', 'in:range,custom'],
            'min_salary' => ['nullable', 'numeric'],
            'max_salary' => ['nullable', 'numeric'],
            'custom_salary' => ['nullable', 'string', 'max:255'],
            'salary_type_id' => ['required', 'integer'],
            'job_experience_id' => ['required', 'integer'],
            'job_role_id' => ['required', 'integer'],
            'education_id' => ['required', 'integer'],
            'job_type_id' => ['required', 'integer'],
            'job_type_id' => ['required', 'integer'],
            'description' => ['required']
        ];
    }
}
