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
            'gender'=>'required',
            'nationality'=>'required',
            'examinee_category'=>'required',
            'exam_category'=>'required'
        ];

        // profile is required only for store, optional for update
        if ($this->isMethod('post')) { // Store method
            $rules['profile'] = 'required|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048';
            // Add custom dimension validation
            $rules['profile'] .= '|dimensions:width=120,height=160'; 
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) { // Update method
            $rules['profile'] = 'nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048';
            // Add custom dimension validation
            $rules['profile'] .= '|dimensions:width=120,height=160'; // 3cm x 4cm (approximately 120x160px)
        }
        

        // citizenship is required only for store, optional for update
        if ($this->isMethod('post')) { // Store method
            $rules['citizenship'] = 'required|mimes:webp,jpeg,png,jpg,svg,pdf|max:2048';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) { // Update method
            $rules['citizenship'] = 'nullable|mimes:webp,jpeg,png,jpg,svg,pdf|max:2048';
        }

        // amount and receipt_image depend on each
        if ($this->isMethod('post')) {
            $rules['amount'] =  'nullable|numeric|required_with:receipt_image';
            $rules['receipt_image'] = 'nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048|required_with:amount';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) { // Update method
            $rules['amount'] =  'nullable|numeric|required_with:receipt_image';
            $rules['receipt_image'] = 'nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048';
        }
        

        return $rules;
    }

    public function messages()
    {
        return [
            'profile.dimensions' => 'The profile image must have dimensions of 120px by 160px (3cm x 4cm).',
        ];
    }
}
