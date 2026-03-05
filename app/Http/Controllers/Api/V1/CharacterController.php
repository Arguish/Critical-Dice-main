<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreCharacterRequest;
use App\Http\Requests\Api\V1\UpdateCharacterRequest;
use App\Http\Resources\CharacterResource;
use App\Models\Character;
use Illuminate\Http\Response;

class CharacterController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /api/v1/characters
     */
    public function index()
    {
        // Get all characters for the authenticated user
        $query = Character::query()->orderBy('created_at', 'desc');

        if (!auth()->user()?->is_admin) {
            $query->where('user_id', auth()->id());
        }

        $characters = $query->get();

        return CharacterResource::collection($characters);
    }

    /**
     * Store a newly created resource in storage.
     * POST /api/v1/characters
     */
    public function store(StoreCharacterRequest $request)
    {
        // Validate and prepare data
        $validated = $request->validated();

        // Create the character (camelCase to snake_case conversion)
        $character = Character::create([
            'user_id' => auth()->id(),
            'system' => $validated['system'],
            'player_name' => $validated['playerName'],
            'character_name' => $validated['characterName'],
            'race' => $validated['race'],
            'class' => $validated['class'],
            'background' => $validated['background'],
            'strength' => $validated['strength'],
            'dexterity' => $validated['dexterity'],
            'constitution' => $validated['constitution'],
            'intelligence' => $validated['intelligence'],
            'wisdom' => $validated['wisdom'],
            'charisma' => $validated['charisma'],
            'applied_modifiers' => $validated['appliedModifiers'] ?? null,
        ]);

        return new CharacterResource($character);
    }

    /**
     * Display the specified resource.
     * GET /api/v1/characters/{id}
     */
    public function show(Character $character)
    {
        // Authorization check: User can only see their own characters
        $this->authorize('view', $character);

        return new CharacterResource($character);
    }

    /**
     * Update the specified resource in storage.
     * PUT/PATCH /api/v1/characters/{id}
     */
    public function update(UpdateCharacterRequest $request, Character $character)
    {
        // Authorization check: User can only update their own characters
        $this->authorize('update', $character);

        // Validate and prepare data
        $validated = $request->validated();

        // Map validated data (camelCase to snake_case)
        $dataToUpdate = [];

        $mapping = [
            'system' => 'system',
            'playerName' => 'player_name',
            'characterName' => 'character_name',
            'race' => 'race',
            'class' => 'class',
            'background' => 'background',
            'strength' => 'strength',
            'dexterity' => 'dexterity',
            'constitution' => 'constitution',
            'intelligence' => 'intelligence',
            'wisdom' => 'wisdom',
            'charisma' => 'charisma',
            'appliedModifiers' => 'applied_modifiers',
        ];

        foreach ($mapping as $camelCase => $snakeCase) {
            if (isset($validated[$camelCase])) {
                $dataToUpdate[$snakeCase] = $validated[$camelCase];
            }
        }

        // Update the character
        $character->update($dataToUpdate);

        return new CharacterResource($character);
    }

    /**
     * Remove the specified resource from storage.
     * DELETE /api/v1/characters/{id}
     */
    public function destroy(Character $character)
    {
        // Authorization check: User can only delete their own characters
        $this->authorize('delete', $character);

        $character->delete();

        // Return 204 No Content
        return response()->noContent();
    }
}
