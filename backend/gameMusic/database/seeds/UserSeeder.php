<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('adminuser'),
            'scope' => 1,
        ]);
        DB::table('users')->insert([
            'name' => 'ゲストユーザー',
            'email' => 'guest@gmail.com',
            'password' => bcrypt('guestuser'),
            'scope' => 2,
        ]);
        DB::table('user_informations')->insert([
            'user_id' => 2,
            'introduce' => 'ゲストユーザーです',
            'instrument' => 'エレキギター、ドラム',
        ]);
    }
}
