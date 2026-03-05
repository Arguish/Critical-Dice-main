<?php

namespace App\Policies;

use App\Models\Character;
use App\Models\User;

class CharacterPolicy
{
    /**
     * Determine whether the user can view the character.
     */
    public function view(User $user, Character $character): bool
    {
        return $user->is_admin === true || $user->id === $character->user_id;
    }

    /**
     * Determine whether the user can update the character.
     */
    public function update(User $user, Character $character): bool
    {
        return $user->is_admin === true || $user->id === $character->user_id;
    }

    /**
     * Determine whether the user can delete the character.
     */
    public function delete(User $user, Character $character): bool
    {
        return $user->is_admin === true || $user->id === $character->user_id;
    }
}
