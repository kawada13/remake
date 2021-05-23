<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('uses')->insert([
            'name' => 'バトル',
        ]);
        DB::table('uses')->insert([
            'name' => '恋愛',
        ]);
        DB::table('uses')->insert([
            'name' => '過去',
        ]);
        DB::table('uses')->insert([
            'name' => '未来',
        ]);
        DB::table('uses')->insert([
            'name' => '日常',
        ]);
    }
}
