<?php

use Illuminate\Database\Seeder;
use App\PizzaSpecialitie;
use App\SpecialityIngredient;

class EspecialidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables([
            'pizza_specialities',
            'speciality_ingredients',
        ]);
        $pizza=new PizzaSpecialitie();
        $pizza->nombre='Pizza hawaiana';
        $pizza->precio=13.99;
        $pizza->masa_id=1;
        $pizza->tamanio_id=3;
        $pizza->save();

        $in=new SpecialityIngredient();
        $in->speciality_id=$pizza->id;
        $in->ingredient_id=2;
        $in->save();
        $in=new SpecialityIngredient();
        $in->speciality_id=$pizza->id;
        $in->ingredient_id=8;
        $in->save();
        $in=new SpecialityIngredient();
        $in->speciality_id=$pizza->id;
        $in->ingredient_id=9;
        $in->save();
    }

    public function truncateTables(array $tables)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }
}
      
}
