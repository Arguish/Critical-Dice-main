<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class CharacterListController extends Controller
{
    public function index()
    {
        $characters = $this->loadCharactersFromCSV();
        return view('characters-list', compact('characters'));
    }

    private function loadCharactersFromCSV()
    {
        $characters = [];
        
        $possiblePaths = [
            'private/characters_dnd.csv',
            'private/private/characters_dnd.csv'
        ];

        $path = null;
        foreach ($possiblePaths as $p) {
            if (Storage::disk('local')->exists($p)) {
                $path = $p;
                break;
            }
        }

        if (!$path) {
            return $characters;
        }

        $content = Storage::disk('local')->get($path);
        $lines = array_filter(explode("\n", $content));

        if (count($lines) < 2) {
            return $characters;
        }

        $header = array_shift($lines);
        $headerValues = $this->parseCSVLine($header);
        $hasGender = in_array('Género', $headerValues);

        foreach ($lines as $line) {
            $values = $this->parseCSVLine($line);
            
            if ($hasGender && count($values) === 13) {
                $character = [
                    'name' => $values[0],
                    'player_name' => $values[1],
                    'gender' => $this->translateGender($values[2]),
                    'race' => $this->translateRace($values[3]),
                    'class' => $this->translateClass($values[4]),
                    'background' => $this->translateBackground($values[5]),
                    'level' => $values[6],
                    'strength' => $values[7],
                    'dexterity' => $values[8],
                    'constitution' => $values[9],
                    'intelligence' => $values[10],
                    'wisdom' => $values[11],
                    'charisma' => $values[12],
                ];
                $characters[] = $character;
            } elseif (!$hasGender && count($values) === 12) {
                $character = [
                    'name' => $values[0],
                    'player_name' => $values[1],
                    'gender' => 'No especificado',
                    'race' => $this->translateRace($values[2]),
                    'class' => $this->translateClass($values[3]),
                    'background' => $this->translateBackground($values[4]),
                    'level' => $values[5],
                    'strength' => $values[6],
                    'dexterity' => $values[7],
                    'constitution' => $values[8],
                    'intelligence' => $values[9],
                    'wisdom' => $values[10],
                    'charisma' => $values[11],
                ];
                $characters[] = $character;
            }
        }

        return $characters;
    }

    private function parseCSVLine($line)
    {
        $values = [];
        $current = '';
        $insideQuotes = false;

        for ($i = 0; $i < strlen($line); $i++) {
            $char = $line[$i];

            if ($char === '"') {
                if ($insideQuotes && isset($line[$i + 1]) && $line[$i + 1] === '"') {
                    $current .= '"';
                    $i++;
                } else {
                    $insideQuotes = !$insideQuotes;
                }
            } elseif ($char === ';' && !$insideQuotes) {
                $values[] = $current;
                $current = '';
            } else {
                $current .= $char;
            }
        }

        if ($current !== '') {
            $values[] = $current;
        }

        return $values;
    }

    private function getGameOptions()
    {
        return [
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
        ];
    }

    private function translateRace($race)
    {
        $gameOptions = $this->getGameOptions();
        return $gameOptions['races'][$race] ?? $race;
    }

    private function translateClass($class)
    {
        $gameOptions = $this->getGameOptions();
        return $gameOptions['classes'][$class] ?? $class;
    }

    private function translateBackground($background)
    {
        $gameOptions = $this->getGameOptions();
        return $gameOptions['backgrounds'][$background] ?? $background;
    }

    private function translateGender($gender)
    {
        $genderMap = [
            'masculino' => 'Masculino',
            'femenino' => 'Femenino',
            'otro' => 'Otro'
        ];
        return $genderMap[$gender] ?? $gender;
    }
}
