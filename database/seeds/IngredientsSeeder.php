<?php

use Illuminate\Database\Seeder;
use App\Ingredient;

class IngredientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->truncateTables([
            'ingredients',
        ]);
        $ingredient=new Ingredient();
        $ingredient->nombre='Peperonni';
        $ingredient->precio=0.99;
        $ingredient->save();
        $ingredient=new Ingredient();
        $ingredient->nombre='Jamón';
        $ingredient->precio=0.99;
        $ingredient->save();
        $ingredient=new Ingredient();
        $ingredient->nombre='Chile verde';
        $ingredient->precio=0.99;
        $ingredient->save();
        $ingredient=new Ingredient();
        $ingredient->nombre='Aceitunas verdes';
        $ingredient->precio=0.99;
        $ingredient->save();
        $ingredient=new Ingredient();
        $ingredient->nombre='Cebolla morada';
        $ingredient->precio=0.99;
        $ingredient->save();
        $ingredient=new Ingredient();
        $ingredient->nombre='Carne de res';
        $ingredient->precio=0.99;
        $ingredient->save();
        $ingredient=new Ingredient();
        $ingredient->nombre='Hongos';
        $ingredient->precio=0.99;
        $ingredient->save();
        $ingredient=new Ingredient();
        $ingredient->nombre='Piña';
        $ingredient->precio=0.99;
        $ingredient->save();
        $ingredient=new Ingredient();
        $ingredient->nombre='Tocino';
        $ingredient->precio=0.99;
        $ingredient->save();
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
