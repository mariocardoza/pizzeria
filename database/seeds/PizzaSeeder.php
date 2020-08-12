<?php

use Illuminate\Database\Seeder;
use App\Tamanio;
use App\Masa;

class PizzaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$this->truncateTables([
            'masas',
            'tamanios',
        ]);
        $masa=new Masa();
        $masa->nombre='Masa alta';
        $masa->precio=0;
        $masa->save();
        $masa=new Masa();
        $masa->nombre='Masa delgada';
        $masa->precio=0;
        $masa->save();

        $tamanio=new Tamanio();
        $tamanio->nombre='Super Personal (4 porciones)';
        $tamanio->precio=6.99;
        $tamanio->save();
        $tamanio=new Tamanio();
        $tamanio->nombre='Grande (8 porciones)';
        $tamanio->precio=9.99;
        $tamanio->save();
        $tamanio=new Tamanio();
        $tamanio->nombre='Gigante (12 porciones)';
        $tamanio->precio=12.99;
        $tamanio->save();
        $tamanio=new Tamanio();
        $tamanio->nombre='Cuatro (16 porciones)';
        $tamanio->precio=15.99;
        $tamanio->save();
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
