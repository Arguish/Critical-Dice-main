<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    /**
     * Especifica qué columnas pueden llenarse con asignación masiva.
     * Esto es por seguridad, para controlar qué datos acepta el modelo.
     */
    protected $fillable = [
        'user_id',
        'system',
        'player_name',
        'character_name',
        'race',
        'class',
        'background',
        'strength',
        'dexterity',
        'constitution',
        'intelligence',
        'wisdom',
        'charisma',
        'applied_modifiers',
    ];

    /**
     * Relationship: A character belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
