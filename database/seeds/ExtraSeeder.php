<?php

use Illuminate\Database\Seeder;
use App\Extra;

class ExtraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncateTables([
            'extras',
        ]);

        $extra= new Extra();
	    $extra->nombre='Soda en lata';
	    $extra->precio=1;
	    $extra->save();

	    $extra= new Extra();
	    $extra->nombre='Soda de 1.5 litros';
	    $extra->precio=1.5;
	    $extra->save();

	    $extra= new Extra();
	    $extra->nombre='Orden pan con ajo';
	    $extra->precio=2.25;
	    $extra->save();
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
