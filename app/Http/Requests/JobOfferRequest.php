<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobOfferRequest extends FormRequest
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
            'title' => $required . '|string',
            'company' => $required . '|string',
            'location' => $required . '|string',
            'description' => $required . '|string',
            'requirements' => 'nullable|string',
            'salary_range' => 'nullable|string',
            'application_link' => 'nullable|url',
            'image' => array_merge(['nullable', \App\Helpers\ConfigHelper::imageRules()]),
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'company' => 'entreprise',
            'location' => 'lieu ou adresse',
            'requirements' => 'exigences',
            'salary_range' => 'salaire',
            'application_link' => 'lien de candidature',
        ];
    }
}
