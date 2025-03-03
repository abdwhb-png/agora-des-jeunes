<?php

namespace App\Http\Requests;

use App\Helpers\ConfigHelper;
use Illuminate\Foundation\Http\FormRequest;

class AgoraSessionRequest extends FormRequest
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
            'published' => ['sometimes', 'boolean'],
            'theme' => ['sometimes', 'string', 'max:300'],
            'lieu' => ['sometimes', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:700'],
            'date' => ['sometimes', 'date'],
            'heure_debut' => ['sometimes', 'date_format:H:i'],
            'heure_fin' => ['nullable', 'date_format:H:i', 'after:heure_debut'],
            'places' => ['sometimes', 'integer', 'min:1'],
            'presentateur' => ['nullable', 'string', 'max:255'],
            'presentateur_id' => ['nullable', 'exists:users,id'],
            'image' => array_merge(['nullable', ConfigHelper::imageRules()]),
        ];
    }

    public function attributes()
    {
        return [
            'theme' => 'thème',
        ];
    }
}
