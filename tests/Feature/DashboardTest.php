<?php

namespace Tests\Feature;

use App\Models\Mahasiswa;
use App\Models\Notifikasi;
use App\Models\ProgramStudi;
use App\Models\Skripsi;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_kaprodi_dashboard_renders_successfully(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_KAPRODI,
        ]);

        $response = $this->actingAs($user)->get(route('kaprodi.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard Kaprodi');
        $response->assertSee('Jumlah Mahasiswa Skripsi');
        $response->assertSee('Mahasiswa Siap Ujian');
        $response->assertSee('Monitoring Yudisium');
    }

    public function test_kaprodi_statistik_page_renders_successfully(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_KAPRODI,
        ]);

        $this->actingAs($user)
            ->get(route('kaprodi.statistik.index'))
            ->assertStatus(200)
            ->assertSee('Statistik Prodi')
            ->assertSee('Rata-rata Lama Skripsi');
    }

    public function test_kaprodi_monitoring_detail_page_renders_successfully(): void
    {
        $user = User::factory()->create(['role' => User::ROLE_KAPRODI]);
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
            'user_id' => $user->id,
            'prodi_id' => $prodi->id,
            'nim' => '2022000001',
            'nama' => 'Rina Wijaya',
            'status_skripsi' => Mahasiswa::STATUS_BIMBINGAN,
        ]);

        Skripsi::create([
            'mahasiswa_id' => $mahasiswa->id,
            'tahun_akademik_id' => $tahunAkademik->id,
            'judul' => 'Analisis Sistem Informasi Akademik',
            'status' => 'aktif',
            'tanggal_mulai' => now()->subDays(18),
        ]);

        $this->actingAs($user)
            ->get(route('kaprodi.monitoring.show', $mahasiswa))
            ->assertStatus(200)
            ->assertSee('Rina Wijaya')
            ->assertSee('Analisis Sistem Informasi Akademik');
    }

    public function test_dosen_dashboard_renders_successfully(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_DOSEN,
        ]);

        $response = $this->actingAs($user)->get(route('dosen.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard Dosen');
    }

    public function test_dekan_dashboard_renders_successfully(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_DEKAN,
        ]);

        $response = $this->actingAs($user)->get(route('dekan.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard Dekan');
        $response->assertSee('SK Menunggu Approval');
        $response->assertSee('SK Disetujui');
        $response->assertSee('Aktivitas Approval Terbaru');
    }

    public function test_dekan_approvals_page_renders_successfully(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_DEKAN,
        ]);

        $this->actingAs($user)
            ->get(route('dekan.approvals.index'))
            ->assertStatus(200)
            ->assertSee('Persetujuan SK')
            ->assertSee('Jenis SK')
            ->assertSee('Nomor SK');
    }

    public function test_super_admin_dashboard_renders_successfully(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_SUPER_ADMIN,
            'name' => 'Admin Utama',
        ]);

        $response = $this->actingAs($user)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard Super Admin');
        $response->assertSee('Manajemen User & Role');
        $response->assertSee('Pengelolaan Skripsi');
        $response->assertSee('Yudisium');
    }

    public function test_pengelola_redirects_to_admin_dashboard(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_PENGELOLA,
            'name' => 'Pengelola Skripsi',
        ]);

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertRedirect(route('admin.dashboard'));
    }

    public function test_laporan_page_renders_successfully(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_SUPER_ADMIN,
            'name' => 'Admin Utama',
        ]);

        $this->actingAs($user)
            ->get(route('admin.laporan.index'))
            ->assertStatus(200)
            ->assertSee('Laporan Rekapitulasi Akademik')
            ->assertSee(route('admin.laporan.rekap-skripsi'))
            ->assertSee(route('admin.laporan.rekap-yudisium'));
    }

    public function test_mahasiswa_dashboard_renders_successfully(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_MAHASISWA,
            'name' => 'Budi Mahasiswa',
        ]);

        $response = $this->actingAs($user)->get(route('mahasiswa.dashboard'));

        $response->assertStatus(200);
        $response->assertSee('Dashboard Mahasiswa');
        $response->assertSee('Selamat Datang, Budi Mahasiswa!');
        $response->assertSee('Pengajuan Judul');
        $response->assertSee('Pendaftaran Yudisium');
    }

    public function test_mahasiswa_yudisium_and_pengesahan_pages_render_successfully(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_MAHASISWA,
            'name' => 'Budi Mahasiswa',
        ]);

        $this->actingAs($user)
            ->get(route('mahasiswa.yudisium.index'))
            ->assertStatus(200)
            ->assertSee('Pendaftaran Yudisium');

        $this->actingAs($user)
            ->get(route('mahasiswa.pengesahan.index'))
            ->assertStatus(200)
            ->assertSee('Upload Lembar Pengesahan');
    }

    public function test_mahasiswa_notifikasi_mark_all_as_read_works(): void
    {
        $user = User::factory()->create([
            'role' => User::ROLE_MAHASISWA,
            'name' => 'Budi Mahasiswa',
        ]);

        Notifikasi::create([
            'user_id' => $user->id,
            'judul' => 'Pengumuman Ujian',
            'pesan' => 'Jadwal ujian akan diinformasikan pada hari Jumat.',
            'tipe' => 'system',
            'is_read' => false,
        ]);

        $this->actingAs($user)
            ->post(route('mahasiswa.notifikasi.read-all'))
            ->assertRedirect(route('mahasiswa.notifikasi.index'));

        $this->assertDatabaseHas('notifikasi', [
            'user_id' => $user->id,
            'judul' => 'Pengumuman Ujian',
            'is_read' => true,
        ]);
    }
}
