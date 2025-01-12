<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestCenterRequest extends FormRequest
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
            'venue_address'=>'required|max:255',
            'test_venue'=>'required|max:255',
            'venue_code'=>'required|max:255',
            'venue_name'=>'required|max:255',
            'phone' => [
                'required',
                'max:255',
                'regex:/^\+?[0-9\s\-\(\)]+$/',
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email' . ($this->isMethod('post') ? '' : ',' . optional($this->test_center->user)->id),
            ],
            'contact_person'=>'required|max:255',
            'mobile_no'=>'required|max:255',
        ];

        // Password is required only for store, optional for update
        if ($this->isMethod('post')) { // Store method
            $rules['password'] = [
                'required',
                'min:8',
                'confirmed',
            ];
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) { // Update method
            $rules['password'] = [
                'nullable', // Not required for updates
                'min:8',
                'confirmed',
            ];
        }
        return $rules;
    }
}
