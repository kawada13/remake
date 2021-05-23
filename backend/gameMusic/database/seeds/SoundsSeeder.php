<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SoundsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sounds')->insert([
            'name' => 'BGM',
        ]);
        DB::table('sounds')->insert([
            'name' => 'SE',
        ]);
        DB::table('sounds')->insert([
            'name' => 'ジングル',
        ]);
        DB::table('sounds')->insert([
            'name' => '声',
        ]);
    }
}
