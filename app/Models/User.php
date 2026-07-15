<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 1;

    public const ROLE_SISWA = 2;

    public const ROLE_TUTOR = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function tutorProfile(): HasOne
    {
        return $this->hasOne(Tutor::class);
    }

    public function trialRegistration(): HasOne
    {
        return $this->hasOne(TrialRegistration::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isSiswa(): bool
    {
        return $this->role === self::ROLE_SISWA;
    }

    public function isTutor(): bool
    {
        return $this->role === self::ROLE_TUTOR;
    }

    public function hasAcceptedRegistration(): bool
    {
        return $this->registrations()->where('status', Registration::STATUS_ACCEPTED)->exists();
    }

    public function hasActiveClassAccess(): bool
    {
        return $this->registrations()
            ->where('status', Registration::STATUS_ACCEPTED)
            ->where('access_starts_at', '<=', now())
            ->where('access_ends_at', '>=', now())
            ->exists();
    }
}
