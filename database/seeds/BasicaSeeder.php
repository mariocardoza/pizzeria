<?php

use Illuminate\Database\Seeder;
use App\PizzaIngredient;

class BasicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables([
            'pizza_ingredients',
        ]);
        $masa=new PizzaIngredient();
        $masa->nombre='Pizza de jamón';
        $masa->precio=12.99;
        $masa->masa_id=1;
        $masa->tamanio_id=3;
        $masa->ingredient_id=2;
        $masa->save();

        $masa=new PizzaIngredient();
        $masa->nombre='Pizza de peperonni';
        $masa->precio=12.99;
        $masa->masa_id=1;
        $masa->tamanio_id=3;
        $masa->ingredient_id=1;
        $masa->save();

        $masa=new PizzaIngredient();
        $masa->nombre='Pizza de jamón';
        $masa->precio=9.99;
        $masa->masa_id=1;
        $masa->tamanio_id=2;
        $masa->ingredient_id=2;
        $masa->save();

        $masa=new PizzaIngredient();
        $masa->nombre='Pizza de peperonni';
        $masa->precio=9.99;
        $masa->masa_id=1;
        $masa->tamanio_id=2;
        $masa->ingredient_id=1;
        $masa->save();
    }

    public function truncateTables(array $tables)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
