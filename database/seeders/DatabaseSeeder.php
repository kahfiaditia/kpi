<?php

namespace Database\Seeders;

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
        $this->call([
            // AkunSeeder::class,
            AgamaSeeder::class,
            SchoolLevelSeeder::class,
            SchoolClassSeeder::class,
            MenuSeeder::class,
            SubMenuSeeder::class,
            BillsSeeder::class,
            KebutuhanKhususSeeder::class,
            SeederSetting::class,
        ]);
    }
}
