<?php

namespace App\Models;

use App\Enums\RolesEnum;

use App\Traits\UserTrait;
use App\Enums\PermissionsEnum;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Activitylog\Traits\CausesActivity;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, SoftDeletes;
    use HasRoles, UserTrait;
    use LogsActivity, CausesActivity;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'phone',
        'email',
        'password',
        'status',
        'last_login_at',
        'last_login_ip',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    protected $with = [
        'info',
        'account',
    ];

    protected static $recordEvents = ['updated', 'deleted'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'last_login_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'boolean',
        ];
    }

    protected function defaultProfilePhotoUrl()
    {
        $name = trim(collect(explode(' ', $this->info->full_name ?? $this->email))->map(function ($segment) {
            return mb_substr($segment, 0, 1);
        })->join(' '));

        return $this->hasRole(RolesEnum::USER->value) ? $this->info->avatar() : 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=7F9CF5&background=EBF4FF';
    }

    protected function profilePhotoUrl(): Attribute
    {
        return Attribute::get(function (): string {
            return $this->profile_photo_path
                ? url('storage/' . $this->profile_photo_path)
                : $this->defaultProfilePhotoUrl();
        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn(string $eventName) => "This user has been {$eventName}")
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }


    public function info(): HasOne
    {
        return $this->hasOne(UserInfo::class);
    }


    public function account(): HasOne
    {
        return $this->hasOne(UserAccount::class);
    }


    public function invitations(): HasMany
    {
        return $this->hasMany(Invitation::class, 'created_by');
    }


    public function activities(): HasMany
    {
        return $this->hasMany(AccountActivity::class);
    }


    public function socials(): HasMany
    {
        return $this->hasMany(Social::class);
    }
}