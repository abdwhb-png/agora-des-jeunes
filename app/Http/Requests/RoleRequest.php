<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'max:255', Rule::unique('users')->ignore($this->route('role')->id ?? null)],
            'description' => ['nullable', 'string', 'max:500'],
            'permissions' => ['nullable', 'array'],
            'permissions.value' => 'sometimes|array',
            'permissions.value.*' => 'sometimes|integer|exists:permissions,id',
            'permissions.status' => 'sometimes|boolean',
            'permission' => 'sometimes|array',
            'permission.id' => 'sometimes|integer|exists:permissions,id',
            'permission.status' => 'sometimes|boolean',
        ];
    }
}