<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeaderRequest extends FormRequest
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
            'title' => 'required|min:10|max:30',
            'description' => 'required|min:10|max:100',
        ];
        if ($this->isMethod('post')) { 
            $rules['image'] = 'required|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048|dimensions:width=2560,height=1704';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) { 
            $rules['image'] = 'nullable|image|mimes:webp,jpeg,png,jpg,gif,svg|max:2048|dimensions:width=2560,height=1704';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'image.dimensions' => 'The image must be 2560x1704 pixels.',
        ];
    }
}
