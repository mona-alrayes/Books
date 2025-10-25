<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
        'title' => 'required|string|max:255',
        'author' => 'required|string|max:255',
        // accept a full date (YYYY-MM-DD) and ensure it's not in the future
        'published_date' => 'nullable|date|before_or_equal:today',
        'description' => 'nullable|string|max:2000',
        'isbn' => 'nullable|string|unique:books,isbn',
    ];
}

/**
 * Get custom messages for validator errors.
 *
 * @return array
 */
public function messages(): array
{
    return [
        'title.required' => 'The book title is required.',
        'author.required' => 'The author name is required.',
        'published_date.date' => 'The published date must be a valid date (YYYY-MM-DD).',
        'published_date.before_or_equal' => 'The published date cannot be in the future.',
        'description.string' => 'The description must be a valid string.',
        'description.max' => 'The description may not be greater than 2000 characters.',
        'isbn.unique' => 'The ISBN must be unique.',
    ];
}

    /**
     * trim inputs and make some of them captilized like title , author 
     *
     * @return void
     */
    public function prepareForValidation(): void
    {
        $this->merge([
            'title' => ucwords(trim($this->title)),
            'author' => ucwords(trim($this->author)),
            'published_date' => $this->filled('published_date') ? trim((string)$this->input('published_date')) : null,
            'isbn' => $this->filled('isbn')? trim($this->input('isbn')) : null,
        ]);
    }
}
