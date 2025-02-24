<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // $user = Auth::check();
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
            'name' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric',
            'new_images' => 'sometimes|required|array',
            'new_images.*' => 'required|image',
            'remove_images' => 'sometimes|required|array',
            'remove_images.*' => 'required|string',
            'description' => 'sometimes|required|string',
            'tagline' => 'sometimes|required|string',
            'new_thumbnail' => 'sometimes|required|file',
            'set_thumbnail' => 'sometimes|required|string'
        ];
    }
}
