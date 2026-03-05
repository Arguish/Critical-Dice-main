<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\User;
use Illuminate\Database\Seeder;

class CharactersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener usuarios para asignarles personajes
        $admin = User::where('email', 'admin@criticaldice.com')->first();
        $user = User::where('email', 'user@criticaldice.com')->first();
        $elena = User::where('email', 'elena@criticaldice.com')->first();
        $carlos = User::where('email', 'carlos@criticaldice.com')->first();

        // Personajes de D&D 5e
        if ($admin) {
            Character::updateOrCreate(
                [
                    'user_id' => $admin->id,
                    'character_name' => 'Thorin Escudo de Hierro',
                ],
                [
                    'system' => 'D&D 5e',
                    'player_name' => $admin->name,
                    'race' => 'Enano',
                    'class' => 'Guerrero',
                    'background' => 'Soldado',
                    'strength' => 16,
                    'dexterity' => 12,
                    'constitution' => 15,
                    'intelligence' => 10,
                    'wisdom' => 13,
                    'charisma' => 8,
                    'applied_modifiers' => 'Resistencia enana +2 CON',
                ]
            );

            Character::updateOrCreate(
                [
                    'user_id' => $admin->id,
                    'character_name' => 'Lyra Brisa Nocturna',
                ],
                [
                    'system' => 'D&D 5e',
                    'player_name' => $admin->name,
                    'race' => 'Elfo',
                    'class' => 'Mago',
                    'background' => 'Sabio',
                    'strength' => 8,
                    'dexterity' => 14,
                    'constitution' => 12,
                    'intelligence' => 17,
                    'wisdom' => 13,
                    'charisma' => 10,
                    'applied_modifiers' => 'Inteligencia élfica +2 INT',
                ]
            );
        }

        if ($user) {
            Character::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'character_name' => 'Grimgar el Salvaje',
                ],
                [
                    'system' => 'D&D 5e',
                    'player_name' => $user->name,
                    'race' => 'Semiorco',
                    'class' => 'Bárbaro',
                    'background' => 'Forastero',
                    'strength' => 18,
                    'dexterity' => 13,
                    'constitution' => 16,
                    'intelligence' => 8,
                    'wisdom' => 11,
                    'charisma' => 9,
                    'applied_modifiers' => 'Fuerza orca +2 FUE, +1 CON',
                ]
            );

            Character::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'character_name' => 'Silas Sombra',
                ],
                [
                    'system' => 'D&D 5e',
                    'player_name' => $user->name,
                    'race' => 'Humano',
                    'class' => 'Pícaro',
                    'background' => 'Criminal',
                    'strength' => 10,
                    'dexterity' => 17,
                    'constitution' => 13,
                    'intelligence' => 14,
                    'wisdom' => 12,
                    'charisma' => 15,
                    'applied_modifiers' => 'Versátil humano +1 todas',
                ]
            );
        }

        // Personajes de Pathfinder
        if ($elena) {
            Character::updateOrCreate(
                [
                    'user_id' => $elena->id,
                    'character_name' => 'Seraphina Luz del Alba',
                ],
                [
                    'system' => 'Pathfinder 2e',
                    'player_name' => $elena->name,
                    'race' => 'Aasimar',
                    'class' => 'Clérigo',
                    'background' => 'Acólito',
                    'strength' => 12,
                    'dexterity' => 10,
                    'constitution' => 14,
                    'intelligence' => 13,
                    'wisdom' => 17,
                    'charisma' => 15,
                    'applied_modifiers' => 'Herencia celestial +2 SAB, +2 CAR',
                ]
            );

            Character::updateOrCreate(
                [
                    'user_id' => $elena->id,
                    'character_name' => 'Kael Ventooscuro',
                ],
                [
                    'system' => 'Pathfinder 2e',
                    'player_name' => $elena->name,
                    'race' => 'Elfo',
                    'class' => 'Explorador',
                    'background' => 'Cazador',
                    'strength' => 14,
                    'dexterity' => 17,
                    'constitution' => 12,
                    'intelligence' => 13,
                    'wisdom' => 15,
                    'charisma' => 9,
                    'applied_modifiers' => 'Agilidad élfica +2 DES',
                ]
            );
        }

        if ($carlos) {
            Character::updateOrCreate(
                [
                    'user_id' => $carlos->id,
                    'character_name' => 'Zephyr Viento Rápido',
                ],
                [
                    'system' => 'Pathfinder 2e',
                    'player_name' => $carlos->name,
                    'race' => 'Gnomo',
                    'class' => 'Hechicero',
                    'background' => 'Artista',
                    'strength' => 8,
                    'dexterity' => 14,
                    'constitution' => 13,
                    'intelligence' => 15,
                    'wisdom' => 10,
                    'charisma' => 17,
                    'applied_modifiers' => 'Carisma gnómico +2 CAR',
                ]
            );

            Character::updateOrCreate(
                [
                    'user_id' => $carlos->id,
                    'character_name' => 'Drogath Martillo de Piedra',
                ],
                [
                    'system' => 'D&D 5e',
                    'player_name' => $carlos->name,
                    'race' => 'Enano de la Montaña',
                    'class' => 'Paladín',
                    'background' => 'Héroe del Pueblo',
                    'strength' => 16,
                    'dexterity' => 10,
                    'constitution' => 16,
                    'intelligence' => 11,
                    'wisdom' => 14,
                    'charisma' => 14,
                    'applied_modifiers' => '+2 CON, +2 FUE (montaña)',
                ]
            );
        }

        // Personajes de Call of Cthulhu
        if ($admin) {
            Character::updateOrCreate(
                [
                    'user_id' => $admin->id,
                    'character_name' => 'Dr. Jonathan Blackwood',
                ],
                [
                    'system' => 'Call of Cthulhu',
                    'player_name' => $admin->name,
                    'race' => 'Humano',
                    'class' => 'Investigador Privado',
                    'background' => 'Ex-detective de policía',
                    'strength' => 12,
                    'dexterity' => 14,
                    'constitution' => 13,
                    'intelligence' => 16,
                    'wisdom' => 15,
                    'charisma' => 11,
                    'applied_modifiers' => null,
                ]
            );
        }

        // Personajes de Vampiro: La Mascarada
        if ($elena) {
            Character::updateOrCreate(
                [
                    'user_id' => $elena->id,
                    'character_name' => 'Isabella de Montfort',
                ],
                [
                    'system' => 'Vampiro: La Mascarada',
                    'player_name' => $elena->name,
                    'race' => 'Vampiro',
                    'class' => 'Toreador',
                    'background' => 'Aristócrata',
                    'strength' => 10,
                    'dexterity' => 15,
                    'constitution' => 12,
                    'intelligence' => 14,
                    'wisdom' => 13,
                    'charisma' => 17,
                    'applied_modifiers' => 'Disciplinas: Auspex 2, Celeridad 1, Presencia 2',
                ]
            );
        }

        // Personajes de Cyberpunk Red
        if ($user) {
            Character::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'character_name' => 'Nex',
                ],
                [
                    'system' => 'Cyberpunk Red',
                    'player_name' => $user->name,
                    'race' => 'Humano',
                    'class' => 'Netrunner',
                    'background' => 'Hacker de las calles',
                    'strength' => 9,
                    'dexterity' => 13,
                    'constitution' => 11,
                    'intelligence' => 17,
                    'wisdom' => 14,
                    'charisma' => 12,
                    'applied_modifiers' => 'Implantes: Cyberdeck +2 INT',
                ]
            );
        }

        $this->command->info('Personajes creados exitosamente!');
    }
}
