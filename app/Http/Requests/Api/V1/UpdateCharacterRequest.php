<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCharacterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'system' => 'sometimes|string|in:dnd,pathfinder,other',
            'playerName' => 'sometimes|string|min:2|max:100',
            'characterName' => 'sometimes|string|min:2|max:100',
            'race' => 'sometimes|string|min:2|max:100',
            'class' => 'sometimes|string|min:2|max:100',
            'background' => 'sometimes|string|min:2|max:255',
            'strength' => 'sometimes|integer|min:1|max:20',
            'dexterity' => 'sometimes|integer|min:1|max:20',
            'constitution' => 'sometimes|integer|min:1|max:20',
            'intelligence' => 'sometimes|integer|min:1|max:20',
            'wisdom' => 'sometimes|integer|min:1|max:20',
            'charisma' => 'sometimes|integer|min:1|max:20',
            'appliedModifiers' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'system.in' => 'El sistema debe ser: dnd, pathfinder u other.',
            'playerName.min' => 'El nombre del jugador debe tener al menos 2 caracteres.',
            'characterName.min' => 'El nombre del personaje debe tener al menos 2 caracteres.',
            'race.min' => 'La raza debe tener al menos 2 caracteres.',
            'class.min' => 'La clase debe tener al menos 2 caracteres.',
            'strength.min' => 'La fuerza debe ser al menos 1.',
            'strength.max' => 'La fuerza no puede exceder 20.',
            'dexterity.min' => 'La destreza debe ser al menos 1.',
            'dexterity.max' => 'La destreza no puede exceder 20.',
            'constitution.min' => 'La constitución debe ser al menos 1.',
            'constitution.max' => 'La constitución no puede exceder 20.',
            'intelligence.min' => 'La inteligencia debe ser al menos 1.',
            'intelligence.max' => 'La inteligencia no puede exceder 20.',
            'wisdom.min' => 'La sabiduría debe ser al menos 1.',
            'wisdom.max' => 'La sabiduría no puede exceder 20.',
            'charisma.min' => 'El carisma debe ser al menos 1.',
            'charisma.max' => 'El carisma no puede exceder 20.',
        ];
    }
}
