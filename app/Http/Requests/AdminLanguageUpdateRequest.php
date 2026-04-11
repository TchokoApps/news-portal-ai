<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminLanguageUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'code' => 'required|string|max:10|unique:languages,code,' . $this->route('language')->id,
            'name' => 'required|string|max:255|unique:languages,name,' . $this->route('language')->id,
            'flag_code' => 'nullable|string|max:10',
            'is_default' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'code.required' => __('languages.code_required'),
            'code.unique' => __('languages.code_unique'),
            'name.required' => __('languages.name_required'),
            'name.unique' => __('languages.name_unique'),
            'name.max' => __('languages.name_max'),
        ];
    }
}
