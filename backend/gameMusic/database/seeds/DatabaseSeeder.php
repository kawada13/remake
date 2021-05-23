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
        $this->call(SoundsSeeder::class);
        $this->call(InstrumentSeeder::class);
        $this->call(UnderstandingSeeder::class);
        $this->call(UseSeeder::class);
    }
}
