<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreCharacterRequest extends FormRequest
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
            'system' => 'required|string|in:dnd,pathfinder,other',
            'playerName' => 'required|string|min:2|max:100',
            'characterName' => 'required|string|min:2|max:100',
            'race' => 'required|string|min:2|max:100',
            'class' => 'required|string|min:2|max:100',
            'background' => 'required|string|min:2|max:255',
            'strength' => 'required|integer|min:1|max:20',
            'dexterity' => 'required|integer|min:1|max:20',
            'constitution' => 'required|integer|min:1|max:20',
            'intelligence' => 'required|integer|min:1|max:20',
            'wisdom' => 'required|integer|min:1|max:20',
            'charisma' => 'required|integer|min:1|max:20',
            'appliedModifiers' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'system.required' => 'El sistema de juego es obligatorio.',
            'system.in' => 'El sistema debe ser: dnd, pathfinder u other.',
            'playerName.required' => 'El nombre del jugador es obligatorio.',
            'playerName.min' => 'El nombre del jugador debe tener al menos 2 caracteres.',
            'characterName.required' => 'El nombre del personaje es obligatorio.',
            'characterName.min' => 'El nombre del personaje debe tener al menos 2 caracteres.',
            'race.required' => 'La raza es obligatoria.',
            'class.required' => 'La clase es obligatoria.',
            'background.required' => 'El trasfondo es obligatorio.',
            'strength.required' => 'La fuerza es obligatoria.',
            'strength.min' => 'La fuerza debe ser al menos 1.',
            'strength.max' => 'La fuerza no puede exceder 20.',
            'dexterity.required' => 'La destreza es obligatoria.',
            'dexterity.min' => 'La destreza debe ser al menos 1.',
            'dexterity.max' => 'La destreza no puede exceder 20.',
            'constitution.required' => 'La constitución es obligatoria.',
            'constitution.min' => 'La constitución debe ser al menos 1.',
            'constitution.max' => 'La constitución no puede exceder 20.',
            'intelligence.required' => 'La inteligencia es obligatoria.',
            'intelligence.min' => 'La inteligencia debe ser al menos 1.',
            'intelligence.max' => 'La inteligencia no puede exceder 20.',
            'wisdom.required' => 'La sabiduría es obligatoria.',
            'wisdom.min' => 'La sabiduría debe ser al menos 1.',
            'wisdom.max' => 'La sabiduría no puede exceder 20.',
            'charisma.required' => 'El carisma es obligatorio.',
            'charisma.min' => 'El carisma debe ser al menos 1.',
            'charisma.max' => 'El carisma no puede exceder 20.',
        ];
    }
}
