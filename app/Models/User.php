<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function role()
{
    return $this->belongsTo(Role::class);
}

public function bisa(string $modul, string $aksi = 'view'): bool
{
    if (! in_array($aksi, ['view', 'create', 'edit', 'delete'])) {
        return false;
    }

    return HakAkses::where('role_id', $this->role_id)
        ->where("can_$aksi", true)
        ->whereHas('module', fn ($q) => $q->where('slug', $modul))
        ->exists();
}
}
