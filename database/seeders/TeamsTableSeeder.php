<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Define number of fake records you want to create
        $numTeams = 40;

        for ($i = 0; $i < $numTeams; $i++) {
            DB::table('teams')->insert([
                'name' => $faker->unique()->word . ' FC',
                'capacity' => $faker->numberBetween(2000, 80000),
                'championship_id' => $faker->numberBetween(1, 4), // Assuming championships have IDs from 1 to 10
                'loan' => $faker->boolean(20), // 20% chance of having a loan
                'manager_id' => $faker->numberBetween(1, 6), // Assuming managers have IDs from 1 to 20
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
