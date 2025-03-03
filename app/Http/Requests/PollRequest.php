<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;

class PollRequest extends FormRequest
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
        $required = $this->isMethod('POST') ? 'required' : 'sometimes';

        return [

            'title' => [
                $required,
                'string',
                'max:255',
                Rule::unique('polls')->ignore($this->route('poll')->id ?? null)
                    ->where(fn(Builder $query) => $query->whereDate('end_at', '>', now())->orWhereNull('end_at')),
            ],
            'is_public' => 'nullable|boolean',
            'description' => 'nullable|string',
            'start_at' => $required . '|date',
            'end_at' => 'nullable|date|after:start_at',
            'show_options' => $required . '|boolean',
            'options' => 'requiredif:show_options,true|array',
            'options.*' => $required . '|array|min:1',
            'options.*.option_text' => $required . '|string|max:255',
            'options.*.id' => $required . '|integer|exists:poll_options,id',
        ];
    }

    public function messages()
    {
        return ['options.requiredif' => 'Veuillez fournir des options de résponse.',];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'is_public' => 'public',
            'start_at' => 'date de debut',
            'end_at' => 'date de fin',
            'show_options' => 'option de réponse',
            'options.*.option_text' => 'valeur de l\'option',
        ];
    }
}
