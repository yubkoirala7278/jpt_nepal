<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
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
        ];

        // profile is required only for store, optional for update
        if ($this->isMethod('post')) { // Store method
            $rules['profile'] = 'required|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) { // Update method
            $rules['profile'] = 'nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048';
        }

        // receipt_image is required only for store, optional for update
        if ($this->isMethod('post')) { // Store method
            $rules['receipt_image'] = 'required|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) { // Update method
            $rules['receipt_image'] = 'nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048';
        }

        return $rules;
    }
}
