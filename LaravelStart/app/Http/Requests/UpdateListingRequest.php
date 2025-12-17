<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateListingRequest extends FormRequest
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
            'service_type_id' => 'sometimes|exists:service_types,id',
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string|min:10',
            'price' => 'sometimes|numeric|min:0',
            'currency' => 'nullable|string|max:3',
            'is_active' => 'nullable|boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'images' => 'nullable|array',
            'images.*.path' => 'required_with:images|string',
            'images.*.alt' => 'nullable|string|max:255',
            'images_files' => 'nullable|array',
            'images_files.*' => 'image|max:5120',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'integer|exists:images,id',
        ];
    }
}
