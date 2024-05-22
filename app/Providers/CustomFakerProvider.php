<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Faker\Generator as FakerGenerator;
use Faker\Factory as FakerFactory;
use Faker\Provider\Base as BaseProvider;

class CustomFakerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Register Faker service
        $this->app->singleton(FakerGenerator::class, function ($app) {
            $faker = FakerFactory::create();

            // Add your custom provider
            $faker->addProvider(new CustomFakerProvider($faker));

            return $faker;
        });
    }
}

class CustomFakerProvider extends BaseProvider
{
    public function teamCapacity($championshipId)
    {
        switch ($championshipId) {
            case 1:
                return $this->generator->numberBetween(60000, 90000);
            case 2:
                return $this->generator->numberBetween(40000, 60000);
            case 3:
                return $this->generator->numberBetween(15000, 40000);
            case 4:
                return $this->generator->numberBetween(5000, 15000);
            default:
                return $this->generator->numberBetween(5000, 90000); // Default range
        }
    }

    public function teamMoney($championshipId)
    {
        switch ($championshipId) {
            case 1:
                return $this->generator->numberBetween(7000000, 10000000);
            case 2:
                return $this->generator->numberBetween(4000000, 7000000);
            case 3:
                return $this->generator->numberBetween(2000000, 4000000);
            case 4:
                return $this->generator->numberBetween(1500000, 2000000);
            default:
                return $this->generator->numberBetween(1500000, 10000000); // Default range
        }
    }

    public function teamMorale()
    {
        return $this->generator->numberBetween(20, 50);
    }
}
