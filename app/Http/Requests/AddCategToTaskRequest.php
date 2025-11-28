<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddCategToTaskRequest extends FormRequest
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
            'categories'   => 'required|array',
            'categories.*' => 'exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'categories.required' => 'Categories field is required.',
            'categories.array'    => 'Categories must be an array.',
            'categories.*.exists' => 'One or more selected categories do not exist.',
        ]; 
    }
}
