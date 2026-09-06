<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'avatar', 'is_active',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    // Roles constants
    const ROLE_SUPER_ADMIN = 'super_admin';

    const ROLE_PENGELOLA = 'pengelola_skripsi';

    const ROLE_KAPRODI = 'kaprodi';

    const ROLE_DEKAN = 'dekan';

    const ROLE_DOSEN = 'dosen';

    const ROLE_MAHASISWA = 'mahasiswa';

    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function isPengelola(): bool
    {
        return $this->role === self::ROLE_PENGELOLA;
    }

    public function isKaprodi(): bool
    {
        return $this->role === self::ROLE_KAPRODI;
    }

    public function isDekan(): bool
    {
        return $this->role === self::ROLE_DEKAN;
    }

    public function isDosen(): bool
    {
        return $this->role === self::ROLE_DOSEN;
    }

    public function isMahasiswa(): bool
    {
        return $this->role === self::ROLE_MAHASISWA;
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, [self::ROLE_SUPER_ADMIN, self::ROLE_PENGELOLA]);
    }

    public function getRoleLabel(): string
    {
        return match ($this->role) {
            self::ROLE_SUPER_ADMIN => 'Super Admin',
            self::ROLE_PENGELOLA => 'Pengelola Skripsi',
            self::ROLE_KAPRODI => 'Kaprodi',
            self::ROLE_DEKAN => 'Dekan',
            self::ROLE_DOSEN => 'Dosen',
            self::ROLE_MAHASISWA => 'Mahasiswa',
            default => ucfirst($this->role),
        };
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/'.$this->avatar);
        }
        $name = urlencode($this->name);

        return "https://ui-avatars.com/api/?name={$name}&background=1e3a5f&color=fff&size=128";
    }

    // Relationships
    public function dosen()
    {
        return $this->hasOne(Dosen::class);
    }

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class);
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }
}
