<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(ExtraSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PizzaSeeder::class);
        $this->call(IngredientsSeeder::class);
        $this->call(BasicaSeeder::class);
        $this->call(EspecialidadSeeder::class);
    }
}
