<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            ProgramStudiSeeder::class,
            TahunAkademikSeeder::class,
            PersyaratanYudisiumSeeder::class,
            UserSeeder::class,
        ]);
    }
}
