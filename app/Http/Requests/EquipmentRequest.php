<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EquipmentRequest extends FormRequest
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
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['required', 'string', 'max:255'],
            'model' => ['required', 'string', 'max:255'],
            'serial_number' => [
                'required', 
                'string', 
                'max:255',
                Rule::unique('equipment')->ignore($this->equipment)
            ],
            'mac_address' => ['nullable', 'string', 'max:17'],
            'category_id' => ['required', 'exists:categories,id'],
            'status_id' => ['required', 'exists:statuses,id'],
            'notes' => ['nullable', 'string'],
            'purchase_date' => ['nullable', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'ip_address' => ['nullable', 'string', 'max:45'],
        ];

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Le nom de l\'équipement est obligatoire.',
            'brand.required' => 'La marque est obligatoire.',
            'model.required' => 'Le modèle est obligatoire.',
            'serial_number.required' => 'Le numéro de série est obligatoire.',
            'serial_number.unique' => 'Ce numéro de série est déjà utilisé.',
            'category_id.required' => 'La catégorie est obligatoire.',
            'status_id.required' => 'Le statut est obligatoire.',
            'mac_address.max' => 'L\'adresse MAC ne doit pas dépasser 17 caractères.',
            'ip_address.max' => 'L\'adresse IP ne doit pas dépasser 45 caractères.',
        ];
    }
}