<?php

namespace Database\Seeders;

use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;

class ProgramStudiSeeder extends Seeder
{
    public function run(): void
    {
        $prodiList = [
            ['kode' => 'TI', 'nama' => 'Teknik Informatika', 'jenjang' => 'S1', 'ketua' => 'Dr. Ir. Ahmad Fauzi, M.Kom.'],
            ['kode' => 'TS', 'nama' => 'Teknik Sipil', 'jenjang' => 'S1', 'ketua' => 'Dr. Ir. Budi Santoso, M.T.'],
            ['kode' => 'TE', 'nama' => 'Teknik Elektro', 'jenjang' => 'S1', 'ketua' => 'Dr. Ir. Citra Lestari, M.T.'],
            ['kode' => 'TM', 'nama' => 'Teknik Mesin', 'jenjang' => 'S1', 'ketua' => 'Dr. Ir. Darmawan Putra, M.T.'],
            ['kode' => 'SI', 'nama' => 'Sistem Informasi', 'jenjang' => 'S1', 'ketua' => 'Dr. Ir. Eka Putri, M.Kom.'],
        ];

        foreach ($prodiList as $prodi) {
            ProgramStudi::updateOrCreate(['kode' => $prodi['kode']], array_merge($prodi, ['status' => true]));
        }
    }
}
