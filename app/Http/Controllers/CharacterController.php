<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Character; // Importar el modelo Character

class CharacterController extends Controller
{
    public function selector()
    {
        return view('character-selector');
    }

    public function form(Request $request)
    {
        $game = $request->query('game', 'dnd');
        $gameOptions = $this->getGameOptions($game);
        return view('character-form', compact('game', 'gameOptions'));
    }

    public function store(Request $request)
    {
        $game = $request->input('game', 'dnd');
        $rules = $this->getValidationRules($game);

        try {
            $data = $request->validate($rules);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect('/character/form?game=' . $game)
                ->withErrors($e->validator->errors());
        }

        // ===========================================
        // PASO 1: Guardar en BASE DE DATOS (nuevo)
        // ===========================================
        try {
            // Preparar los datos para el modelo Character
            $characterData = [
                'user_id' => auth()->id(), // Asignar el ID del usuario autenticado
                'system' => $game,
                'player_name' => $data['player_name'],
                'character_name' => $data['name'], // El form usa 'name', la BD 'character_name'
                'race' => $data['race'],
                'class' => $data['class'],
                'background' => $data['background'],
                'strength' => $data['strength'],
                'dexterity' => $data['dexterity'],
                'constitution' => $data['constitution'],
                'intelligence' => $data['intelligence'],
                'wisdom' => $data['wisdom'],
                'charisma' => $data['charisma'],
                'applied_modifiers' => $request->input('applied_modifiers', null), // Opcional
            ];

            // Crear registro en la tabla 'characters'
            Character::create($characterData);

            Log::info('Personaje guardado en BD: ' . $data['name']);
        } catch (\Exception $e) {
            Log::error('Error al guardar en BD: ' . $e->getMessage());
            // Si falla BD, continuamos para guardar en CSV (no bloqueamos el flujo)
        }

        // ===========================================
        // PASO 2: Guardar en CSV (código original)
        // ===========================================
        $line = $this->formatCharacterLine($game, $data);

        try {
            $dir = 'private';
            $filename = 'characters_' . $game . '.csv';
            $path = $dir . '/' . $filename;

            if (!Storage::disk('local')->exists($dir)) {
                Storage::disk('local')->makeDirectory($dir);
            }

            if (!Storage::disk('local')->exists($path)) {
                $header = $this->getCharacterHeader($game);
                Storage::disk('local')->put($path, $header);
            }

            Storage::disk('local')->append($path, rtrim($line, "\n"));

            $displayData = $this->translateCharacterData($game, $data);

            return redirect('/character/success')
                ->with('character_data', $displayData);
        } catch (\Exception $e) {
            Log::error('Error al guardar CSV de personajes: ' . $e->getMessage());
            return redirect('/character/form?game=' . $game)
                ->with('error', 'No se pudo guardar el personaje. Error: ' . $e->getMessage());
        }
    }

    public function success()
    {
        return view('character-success');
    }

    private function getGameOptions($game)
    {
        $options = [
            'dnd' => [
                'races' => [
                    'human' => 'Humano',
                    'elf' => 'Elfo',
                    'dwarf' => 'Enano',
                    'halfling' => 'Mediano',
                    'dragonborn' => 'Dracónido',
                    'gnome' => 'Gnomo',
                    'half_elf' => 'Medio Elfo',
                    'half_orc' => 'Medio Orco',
                    'tiefling' => 'Tiefling'
                ],
                'classes' => [
                    'barbarian' => 'Bárbaro',
                    'bard' => 'Bardo',
                    'cleric' => 'Clérigo',
                    'druid' => 'Druida',
                    'fighter' => 'Guerrero',
                    'monk' => 'Monje',
                    'paladin' => 'Paladín',
                    'ranger' => 'Cazador',
                    'rogue' => 'Pícaro',
                    'sorcerer' => 'Hechicero',
                    'warlock' => 'Brujo',
                    'wizard' => 'Mago'
                ],
                'backgrounds' => [
                    'acolyte' => 'Acólito',
                    'charlatan' => 'Charlatán',
                    'criminal' => 'Criminal',
                    'entertainer' => 'Artista',
                    'folk_hero' => 'Héroe Popular',
                    'gladiator' => 'Gladiador',
                    'guild_artisan' => 'Artesano',
                    'hermit' => 'Ermitaño',
                    'noble' => 'Noble',
                    'outlander' => 'Salvaje',
                    'sage' => 'Sabio',
                    'sailor' => 'Marinero',
                    'soldier' => 'Soldado',
                    'urchin' => 'Golfo'
                ]
            ]
        ];

        return $options[$game] ?? $options['dnd'];
    }

    private function getValidationRules($game)
    {
        if ($game === 'dnd') {
            return [
                'name' => 'required|string|max:255',
                'player_name' => 'required|string|max:255',
                'gender' => 'required|in:masculino,femenino,otro',
                'race' => 'required|string',
                'class' => 'required|string',
                'background' => 'required|string',
                'level' => 'required|integer|min:1|max:20',
                'strength' => 'required|integer|min:3|max:20',
                'dexterity' => 'required|integer|min:3|max:20',
                'constitution' => 'required|integer|min:3|max:20',
                'intelligence' => 'required|integer|min:3|max:20',
                'wisdom' => 'required|integer|min:3|max:20',
                'charisma' => 'required|integer|min:3|max:20',
            ];
        }

        return [];
    }

    private function getCharacterHeader($game)
    {
        if ($game === 'dnd') {
            return "\"Nombre del Personaje\";\"Nombre del Jugador\";\"Género\";\"Raza\";\"Clase\";\"Trasfondo\";\"Nivel\";\"Fuerza\";\"Destreza\";\"Constitución\";\"Inteligencia\";\"Sabiduría\";\"Carisma\"\n";
        }

        return "";
    }

    private function formatCharacterLine($game, $data)
    {
        if ($game === 'dnd') {
            return sprintf(
                "\"%s\";\"%s\";\"%s\";\"%s\";\"%s\";\"%s\";\"%s\";\"%s\";\"%s\";\"%s\";\"%s\";\"%s\";\"%s\"\n",
                str_replace('"', '""', $data['name']),
                str_replace('"', '""', $data['player_name']),
                str_replace('"', '""', $data['gender']),
                str_replace('"', '""', $data['race']),
                str_replace('"', '""', $data['class']),
                str_replace('"', '""', $data['background']),
                str_replace('"', '""', $data['level']),
                str_replace('"', '""', $data['strength']),
                str_replace('"', '""', $data['dexterity']),
                str_replace('"', '""', $data['constitution']),
                str_replace('"', '""', $data['intelligence']),
                str_replace('"', '""', $data['wisdom']),
                str_replace('"', '""', $data['charisma'])
            );
        }

        return "";
    }

    private function translateCharacterData($game, $data)
    {
        if ($game === 'dnd') {
            $gameOptions = $this->getGameOptions($game);
            $translatedData = $data;

            if (isset($gameOptions['races'][$data['race']])) {
                $translatedData['race'] = $gameOptions['races'][$data['race']];
            }
            if (isset($gameOptions['classes'][$data['class']])) {
                $translatedData['class'] = $gameOptions['classes'][$data['class']];
            }
            if (isset($gameOptions['backgrounds'][$data['background']])) {
                $translatedData['background'] = $gameOptions['backgrounds'][$data['background']];
            }

            $genderMap = [
                'masculino' => 'Masculino',
                'femenino' => 'Femenino',
                'otro' => 'Otro'
            ];
            if (isset($genderMap[$data['gender']])) {
                $translatedData['gender'] = $genderMap[$data['gender']];
            }

            return $translatedData;
        }

        return $data;
    }
}
