<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CharacterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'userId' => $this->user_id,
            'system' => $this->system,
            'playerName' => $this->player_name,
            'characterName' => $this->character_name,
            'race' => $this->race,
            'class' => $this->class,
            'background' => $this->background,
            'attributes' => [
                'strength' => $this->strength,
                'dexterity' => $this->dexterity,
                'constitution' => $this->constitution,
                'intelligence' => $this->intelligence,
                'wisdom' => $this->wisdom,
                'charisma' => $this->charisma,
            ],
            'appliedModifiers' => $this->applied_modifiers,
            'createdAt' => $this->created_at?->toIso8601String(),
            'updatedAt' => $this->updated_at?->toIso8601String(),
        ];
    }
}
