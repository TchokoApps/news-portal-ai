<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_breaking_news' => $this->boolean('is_breaking_news'),
            'show_at_slider' => $this->boolean('show_at_slider'),
            'show_at_popular' => $this->boolean('show_at_popular'),
            'status' => $this->boolean('status'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $newsId = $this->route('news')->id;

        return [
            'language' => 'required|string',
            'category' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:3072',
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('news', 'title')->ignore($newsId),
            ],
            'content' => 'required|string',
            'tags' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'is_breaking_news' => 'nullable|boolean',
            'show_at_slider' => 'nullable|boolean',
            'show_at_popular' => 'nullable|boolean',
            'status' => 'nullable|boolean',
        ];
    }
}
