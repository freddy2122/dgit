<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property-read LicenseSummary|null $licenseSummary
 * @property-read Collection<int, Vehicle> $vehicles
 * @property-read Collection<int, PortalNotification> $portalNotifications
 * @property-read Collection<int, PortalPayment> $portalPayments
 * @property-read Collection<int, PortalAppointment> $portalAppointments
 */
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
        'first_name',
        'last_name',
        'email',
        'password',
        'nie',
        'phone',
        'birth_date',
        'address',
        'auth_method',
        'is_active',
        'dossier_number',
        'verification_code',
        'dni_recto_path',
        'dni_verso_path',
        'signature_path',
        'license_photo_path',
        'role',
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
        'birth_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isAgent(): bool
    {
        return in_array($this->role, ['admin', 'agent', 'agent_permis', 'agent_vehicules', 'agent_multas', 'support'], true);
    }

    /** Agent DGT ou super admin (accès /admin). */
    public function isStaff(): bool
    {
        return $this->isAdmin() || $this->isAgent();
    }

    public function permitApplication(): HasOne
    {
        return $this->hasOne(PermitApplication::class)->latestOfMany();
    }

    public function permitApplications(): HasMany
    {
        return $this->hasMany(PermitApplication::class);
    }

    public function licensePointEvents(): HasMany
    {
        return $this->hasMany(LicensePointEvent::class)->latest('occurred_at');
    }

    public function licenseSummary(): HasOne
    {
        return $this->hasOne(LicenseSummary::class);
    }

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    public function portalNotifications(): HasMany
    {
        return $this->hasMany(PortalNotification::class);
    }

    public function portalPayments(): HasMany
    {
        return $this->hasMany(PortalPayment::class);
    }

    public function portalAppointments(): HasMany
    {
        return $this->hasMany(PortalAppointment::class);
    }

    public function qrTokens(): HasMany
    {
        return $this->hasMany(QrToken::class);
    }
}
