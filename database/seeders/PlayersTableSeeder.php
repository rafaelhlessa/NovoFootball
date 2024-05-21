<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PlayersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


            $faker = Faker::create();

            // Define number of players for each division
            $playersPerTeam = [
                '1' => 25,
                '2' => 22,
                '3' => 20,
                '4' => 20
            ];

            foreach ($playersPerTeam as $division => $numPlayers) {
                $teams = DB::table('teams')->where('championship_id', $division)->get();
                foreach ($teams as $team) {
                    for ($i = 0; $i < $numPlayers; $i++) {
                        DB::table('player')->insert([
                            'name' => $faker->name,
                            'position' => $faker->randomElement(['Forward', 'Midfielder', 'Defender', 'Goalkeeper']),
                            'age' => $faker->numberBetween(18, 40),
                            'strength' => $faker->numberBetween(50, 100),
                            'goals' => $faker->numberBetween(0, 50),
                            'yellow_cards' => $faker->numberBetween(0, 10),
                            'red_cards' => $faker->numberBetween(0, 5),
                            'price' => $faker->numberBetween(100000, 10000000),
                            'team_id' => $team->id,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }

            // Players without a team
            $totalTeams = DB::table('teams')->count();
            $totalPlayers = array_sum($playersPerTeam);
            $playersWithoutTeam = $totalPlayers - $totalTeams * $numPlayers; // Total number of players - (number of teams * players per team)
            for ($i = 0; $i < $playersWithoutTeam; $i++) {
                DB::table('player')->insert([
                    'name' => $faker->name,
                    'position' => $faker->randomElement(['Forward', 'Midfielder', 'Defender', 'Goalkeeper']),
                    'age' => $faker->numberBetween(18, 40),
                    'strength' => $faker->numberBetween(50, 100),
                    'goals' => $faker->numberBetween(0, 50),
                    'yellow_cards' => $faker->numberBetween(0, 10),
                    'red_cards' => $faker->numberBetween(0, 5),
                    'price' => $faker->numberBetween(100000, 10000000),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
    }
}
