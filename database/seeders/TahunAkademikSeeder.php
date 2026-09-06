<?php

namespace Database\Seeders;

use App\Models\TahunAkademik;
use Illuminate\Database\Seeder;

class TahunAkademikSeeder extends Seeder
{
    public function run(): void
    {
        TahunAkademik::updateOrCreate(
            ['tahun' => '2024/2025', 'semester' => 'Ganjil'],
            ['is_aktif' => false, 'tanggal_mulai' => '2024-09-01', 'tanggal_selesai' => '2025-01-31']
        );
        TahunAkademik::updateOrCreate(
            ['tahun' => '2024/2025', 'semester' => 'Genap'],
            ['is_aktif' => false, 'tanggal_mulai' => '2025-02-01', 'tanggal_selesai' => '2025-06-30']
        );
        TahunAkademik::updateOrCreate(
            ['tahun' => '2025/2026', 'semester' => 'Ganjil'],
            ['is_aktif' => true, 'tanggal_mulai' => '2025-09-01', 'tanggal_selesai' => '2026-01-31']
        );
    }
}
