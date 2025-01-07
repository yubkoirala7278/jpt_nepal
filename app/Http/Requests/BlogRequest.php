<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
            'title'=>'required|max:255',
            'description'=>'required',
            'status'=>'required'            
        ];
        if ($this->isMethod('post')) { // Store method
            $rules['image'] = 'required|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) { // Update method
            $rules['image'] = 'nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048';
        }

        return $rules;
    }
}
