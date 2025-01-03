<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegistrationRequest extends FormRequest
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
        $rules = [
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'phone' => 'required|max:255',
            'dob' => 'required',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('students', 'email')->ignore($this->route('student'), 'slug')
            ],
            'is_appeared_previously' => 'nullable',
            'exam_date' => 'required',
            'amount' => 'required|numeric',
            'receipt_image' => 'required|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048',
            'profile' => 'required|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048',
            'citizenship' => 'required|mimes:webp,jpeg,png,jpg,svg,pdf|max:2048',
            'test_center'=>'required'
        ];

        return $rules;
    }
}
