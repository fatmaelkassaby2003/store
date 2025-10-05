<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
        'name'        => 'required|string|max:255',
        'description' => 'nullable|string|max:1000',
        'price'       => 'required|numeric|min:0',
        'image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        'category'    => 'required|string|max:255',
        'size'        => 'required|numeric|min:1',
        'company_id'  => 'nullable|exists:companies,id',
        // 'type`'       => 'nullable|string|max:255',
        ];
    }
}
