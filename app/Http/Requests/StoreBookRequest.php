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
            'published_year' => 'nullable|integer|min:1900|max:' . date('Y'), // Ensure the year is not in the future
            'description' => 'nullable|string|max:2000',
            'isbn' => 'nullable|string|unique:books,isbn',
        ];
    }
    /**
     * validation messages 
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The book title is required.',
            'author.required' => 'The author name is required.',
            'published_year.integer' => 'The published year must be a valid year.',
            'published_year.min' => 'The published year must be at least 1900.',
            'published_year.max' => 'The published year cannot be in the future.',
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
            'published_year' => $this->filled('published_year') ? trim((string)$this->input('published_year')) : null,
            'isbn' => $this->filled('isbn')? trim($this->input('isbn')) : null,
        ]);
    }
}
