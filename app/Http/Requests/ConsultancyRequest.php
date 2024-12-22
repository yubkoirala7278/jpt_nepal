<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ConsultancyRequest extends FormRequest
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
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email' . ($this->isMethod('post') ? '' : ',' . optional($this->consultancy->user)->id),
            ],
            'phone' => [
                'required',
                'max:255',
                'regex:/^\+?[0-9\s\-\(\)]+$/',
            ],
            'address' => 'required|max:255',
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

        // Logo is required only for store, optional for update
        if ($this->isMethod('post')) { // Store method
            $rules['logo'] = 'required|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) { // Update method
            $rules['logo'] = 'nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048';
        }

        // assign to test center 
        if(Auth::user()->hasRole('admin')){
            $rules['test_center']='required';
        }

        return $rules;
    }
}
