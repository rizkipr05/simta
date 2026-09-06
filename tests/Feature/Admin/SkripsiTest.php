<?php

namespace Tests\Feature\Admin;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\ProgramStudi;
use App\Models\Skripsi;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SkripsiTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_skripsi_show_renders_with_dosen_list(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_SUPER_ADMIN,
        ]);

        $prodi = ProgramStudi::create([
            'kode' => 'TI',
            'nama' => 'Teknik Informatika',
            'jenjang' => 'S1',
            'status' => true,
        ]);

        $tahunAkademik = TahunAkademik::create([
            'tahun' => '2025/2026',
            'semester' => 'Ganjil',
            'tanggal_mulai' => now()->subMonth(),
            'tanggal_selesai' => now()->addMonths(6),
            'is_aktif' => true,
        ]);

        $mahasiswa = Mahasiswa::create([
            'user_id' => $admin->id,
            'prodi_id' => $prodi->id,
            'nim' => '2022000001',
            'nama' => 'Test Mahasiswa',
            'status_skripsi' => Mahasiswa::STATUS_BIMBINGAN,
        ]);

        $skripsi = Skripsi::create([
            'mahasiswa_id' => $mahasiswa->id,
            'tahun_akademik_id' => $tahunAkademik->id,
            'judul' => 'Judul Skripsi Testing',
            'status' => 'aktif',
            'tanggal_mulai' => now()->subDays(10),
        ]);

        $dosenUser = User::factory()->create([
            'role' => User::ROLE_DOSEN,
        ]);

        Dosen::create([
            'user_id' => $dosenUser->id,
            'prodi_id' => $prodi->id,
            'nidn' => '0011223344',
            'nama' => 'Dr. Dosen Test',
            'is_aktif' => true,
        ]);

        $response = $this->actingAs($admin)
            ->get(route('admin.skripsi.show', $skripsi));

        $response->assertStatus(200);
        $response->assertViewHas('dosenList');
        $response->assertSee('Dr. Dosen Test');
    }
}
