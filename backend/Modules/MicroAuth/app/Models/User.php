<?php

namespace Modules\MicroAuth\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $connection = 'microauth';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ─── Relaciones ───────────────────────────────────────────────────────────

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // ─── Helpers de rol ───────────────────────────────────────────────────────

    public function hasRole(string $role): bool
    {
        return $this->role?->nombre === $role;
    }

    public function isAdmin(): bool      { return $this->hasRole('Administrador'); }
    public function isDeveloper(): bool  { return $this->hasRole('Desarrollador'); }
    public function isSupervisor(): bool { return $this->hasRole('Supervisor'); }
    public function isUser(): bool       { return $this->hasRole('Usuario'); }
}
