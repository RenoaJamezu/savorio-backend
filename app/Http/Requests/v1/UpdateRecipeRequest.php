<?php

namespace App\Http\Requests\v1;

use App\Models\Recipe;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRecipeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() ? $this->user()->can('update', $this->route('recipe')) : false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'sometimes|exists:users,id',
            'title' => 'sometimes|nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'prep_time' => 'nullable|integer|min:0',
            'cook_time' => 'nullable|integer|min:0',
            'difficulty' => 'sometimes|nullable|string',
            'image_url' => 'nullable|string',
        ];
    }
}
