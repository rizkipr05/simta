<?php

namespace Tests\Feature;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginByIdentifierTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_with_email_nim_and_nidn()
    {
        // create dosen user
        $dosenUser = User::create([
            'name' => 'Dosen Test',
            'email' => 'dosen-test@simta.local',
            'password' => Hash::make('password'),
            'role' => User::ROLE_DOSEN,
            'is_active' => true,
        ]);

        $prodi = \App\Models\ProgramStudi::create([
            'kode' => 'TI',
            'nama' => 'Teknik Informatika',
            'jenjang' => 'S1',
        ]);

        $dosen = Dosen::create([
            'user_id' => $dosenUser->id,
            'prodi_id' => $prodi->id,
            'nidn' => 'NIDN12345',
            'nama' => 'Dosen Test',
            'email' => $dosenUser->email,
        ]);

        // create mahasiswa user
        $mhsUser = User::create([
            'name' => 'Mhs Test',
            'email' => 'mhs-test@simta.local',
            'password' => Hash::make('password'),
            'role' => User::ROLE_MAHASISWA,
            'is_active' => true,
        ]);

        $mhs = Mahasiswa::create([
            'user_id' => $mhsUser->id,
            'prodi_id' => $prodi->id,
            'nim' => 'NIM12345',
            'nama' => 'Mhs Test',
            'email' => $mhsUser->email,
        ]);

        // login via email
        $response = $this->post('/login', [
            'email' => $mhsUser->email,
            'password' => 'password',
        ]);
        $response->assertRedirect();
        $this->assertAuthenticatedAs($mhsUser);

        auth()->logout();

        // login via NIM
        $response = $this->post('/login', [
            'email' => $mhs->nim,
            'password' => 'password',
        ]);
        $response->assertRedirect();
        $this->assertAuthenticatedAs($mhsUser);

        auth()->logout();

        // login via NIDN
        $response = $this->post('/login', [
            'email' => $dosen->nidn,
            'password' => 'password',
        ]);
        $response->assertRedirect();
        $this->assertAuthenticatedAs($dosenUser);
    }
}
