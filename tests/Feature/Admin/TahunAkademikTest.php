<?php

namespace Tests\Feature\Admin;

use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TahunAkademikTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_form_renders_valid_semester_options(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_SUPER_ADMIN,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.master.tahun-akademik.create'));

        $response->assertOk();
        $response->assertSee('value="Ganjil"', false);
        $response->assertSee('value="Genap"', false);
    }

    public function test_admin_can_store_tahun_akademik_with_ganjil_and_set_aktif(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_SUPER_ADMIN,
        ]);

        $existing = TahunAkademik::create([
            'tahun' => '2024/2025',
            'semester' => 'Genap',
            'is_aktif' => true,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.master.tahun-akademik.store'), [
            'tahun' => '2025/2026',
            'semester' => 'Ganjil',
            'is_aktif' => '1',
        ]);

        $response->assertRedirect(route('admin.master.tahun-akademik.index'));
        $this->assertDatabaseHas('tahun_akademik', [
            'tahun' => '2025/2026',
            'semester' => 'Ganjil',
            'is_aktif' => true,
        ]);
        $this->assertFalse($existing->fresh()->is_aktif);
    }

    public function test_store_rejects_invalid_semester(): void
    {
        $admin = User::factory()->create([
            'role' => User::ROLE_SUPER_ADMIN,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.master.tahun-akademik.store'), [
            'tahun' => '2025/2026',
            'semester' => 'ganjil',
        ]);

        $response->assertSessionHasErrors('semester');
    }
}
