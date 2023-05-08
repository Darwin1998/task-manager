<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StoreSkillRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return Validator::make(StoreSkillRequest::class,[
            'name' => 'required|min:2|max:15',
            'slug' => 'required|unique:skill,slug'
        ]);
    }

    public function messages(): array
    {
        return [
            'name.required' => 'A name is required',
            'name.min' => 'The name must be at least :min characters',
            'name.max' => 'The name may not be greater than :max characters',
            'slug.required' => 'A slug is required',
            'slug.unique' => 'The slug has already been taken',
        ];
    }

}
