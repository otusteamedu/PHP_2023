<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrackAddRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'author' => 'required|string',
            'genre_id' => 'required|integer',
            'file' => 'required|file'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'A name is required',
            'author.required' => 'A author is required',
            'genre_id.required' => 'A genre_id is required',
            'file.required' => 'A file is required',
        ];
    }
}
