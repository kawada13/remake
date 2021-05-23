<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnderstandingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('understandings')->insert([
            'name' => '華やか',
        ]);
        DB::table('understandings')->insert([
            'name' => '悲しい',
        ]);
        DB::table('understandings')->insert([
            'name' => '楽しい',
        ]);
        DB::table('understandings')->insert([
            'name' => '未来',
        ]);
        DB::table('understandings')->insert([
            'name' => 'ホラー',
        ]);
    }
}
