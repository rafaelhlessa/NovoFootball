<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Faker\Factory as FakerFactory;
use App\Providers\CustomFakerProvider;

class TeamsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = FakerFactory::create();

        // Add your custom provider
        $faker->addProvider(new CustomFakerProvider($faker));

        // Define number of fake records you want to create
        $numTeams = 32;

        for ($i = 0; $i < $numTeams; $i++) {
            $championshipId = $faker->numberBetween(1, 4);

            DB::table('teams')->insert([
                'name' => $faker->unique()->word . ' FC',
                'capacity' => $faker->teamCapacity($championshipId),
                'championship_id' => $championshipId,
                'loan' => $faker->boolean(20), // 20% chance of having a loan
                'morale' => $faker->teamMorale(),
                'money' => $faker->teamMoney($championshipId),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
