<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
        $rules= [
            'bank_name'=>'required',
            'account_name'=>'required|max:255',
            'account_number'=>'required|numeric',
            'branch_name'=>'required|max:255',
        ];

        if ($this->isMethod('post')) { 
            $rules['qr_code'] = 'required|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) { 
            $rules['qr_code'] = 'nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048';
        }
        return $rules;
    }
}
