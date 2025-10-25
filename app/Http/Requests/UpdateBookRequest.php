<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
            'title' => 'sometimes|nullable|string|max:255',
            'author' => 'sometimes|nullable|string|max:255',
            'published_date' => 'sometimes|nullable|integer|min:1900|max:' . date('Y'), // Ensure the year is not in the future
            'description' => 'sometimes|nullable|string|max:2000',
            'isbn' => 'sometimes|nullable|string|unique:books,isbn,' . $this->route('book')->id,  // Ignore current book's ISBN
        ];
    }

    public function messages() : array
    {
        return [
            'title.string' => 'The book title must be a string.',
            'author.string' => 'The author name must be a string.',
            'published_date.integer' => 'The published year must be a valid year.',
            'published_date.min' => 'The published year must be at least 1900.',
            'published_date.max' => 'The published year cannot be in the future.',
            'description.string' => 'The description must be a valid string.',
            'description.max' => 'The description may not be greater than 2000 characters.',
            'isbn.unique' => 'The ISBN must be unique.',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'title' => $this->input('title') ? ucwords(trim((string)$this->input('title'))) : null,
            'author' => $this->input('author') ? ucwords(trim((string)$this->input('author'))) : null,
            'published_date' => $this->filled('published_date') ? (int) trim((string)$this->input('published_date')) : null,
            'isbn' => $this->filled('isbn')? trim($this->input('isbn')) : null,
        ]);
    }
}
