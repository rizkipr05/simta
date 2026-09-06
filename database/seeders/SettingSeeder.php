<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'nama_institusi', 'value' => 'Universitas Muhammadiyah Maluku Utara', 'type' => 'text', 'group' => 'institusi'],
            ['key' => 'singkatan_institusi', 'value' => 'UMMU', 'type' => 'text', 'group' => 'institusi'],
            ['key' => 'nama_fakultas', 'value' => 'Fakultas Teknik', 'type' => 'text', 'group' => 'institusi'],
            ['key' => 'singkatan_fakultas', 'value' => 'FT', 'type' => 'text', 'group' => 'institusi'],
            ['key' => 'alamat', 'value' => 'Jl. Bumi Bahari, Kota Ternate, Maluku Utara', 'type' => 'textarea', 'group' => 'institusi'],
            ['key' => 'telepon', 'value' => '(0921) 123456', 'type' => 'text', 'group' => 'institusi'],
            ['key' => 'email_institusi', 'value' => 'info@ummu.ac.id', 'type' => 'text', 'group' => 'institusi'],
            ['key' => 'website', 'value' => 'https://ummu.ac.id', 'type' => 'text', 'group' => 'institusi'],
            ['key' => 'nama_dekan', 'value' => 'Dr. Ir. H. Syahrul Ramadhan, M.T.', 'type' => 'text', 'group' => 'pejabat'],
            ['key' => 'nip_dekan', 'value' => '196001011990031001', 'type' => 'text', 'group' => 'pejabat'],
            ['key' => 'logo_path', 'value' => null, 'type' => 'file', 'group' => 'branding'],
            ['key' => 'nomor_sk_format', 'value' => 'SK/{nomor}/{bulan}/{tahun}', 'type' => 'text', 'group' => 'format'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
