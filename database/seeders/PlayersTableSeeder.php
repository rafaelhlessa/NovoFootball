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
        $goalkeepersCount = 0; // Track the number of goalkeepers
        for ($i = 0; $i < $numPlayers; $i++) {
            $position = $faker->randomElement(['Forward', 'Midfielder', 'Defender', 'Goalkeeper']);

            // Ensure maximum 3 and minimum 2 goalkeepers per team
            if ($position === 'Goalkeeper' && $goalkeepersCount >= 2) {
                $position = $faker->randomElement(['Forward', 'Midfielder', 'Defender']);
            }

            if ($position === 'Goalkeeper') {
                $goalkeepersCount++;
            }

            $strength = $faker->numberBetween(50, 100);
            $price = $faker->numberBetween(100000, 10000000);
            $salary = 0;

            // Define salary and price based on team and strength
            switch ($team->id) {
                case 1:
                    $salary = $faker->numberBetween(50000, 70000) * ($strength / 100);
                    $price = $faker->numberBetween(8000000, 15000000) * ($strength / 100);
                    break;
                case 2:
                    $salary = $faker->numberBetween(30000, 50000) * ($strength / 100);
                    $price = $faker->numberBetween(6000000, 10000000) * ($strength / 100);
                    break;
                case 3:
                    $salary = $faker->numberBetween(10000, 30000) * ($strength / 100);
                    $price = $faker->numberBetween(4000000, 8000000) * ($strength / 100);
                    break;
                case 4:
                    $salary = $faker->numberBetween(1000, 10000) * ($strength / 100);
                    $price = $faker->numberBetween(80000, 2000000) * ($strength / 100);
                    break;
            }

            DB::table('player')->insert([
                'name' => $faker->name,
                'position' => $position,
                'strength' => $strength,
                'goals' => $faker->numberBetween(0, 50),
                'red_cards' => $faker->numberBetween(0, 5),
                'price' => $price,
                'salary' => $salary,
                //'contract' => $faker->numberBetween(1, 5), // Random contract length
                'star' => $faker->boolean(20), // 20% chance of being a star
                'team_id' => $team->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

    }
}
