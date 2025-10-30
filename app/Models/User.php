<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Events\Login;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Observers\CreatedAndUpdatedByObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
#[ObservedBy([CreatedAndUpdatedByObserver::class])]
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'country_id',
        'business_unit_id',
        'password',
        'avatar',
        'status',
        'language',
        'date_time_format',
        'default_home_page',
        'created_by',
        'updated_by',
        'latest_login',
        'login_ip',
        'manager_id',
        'address_line_1',
        'address_line_2',
        'zipcode',
        'city',
        'country'
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function businessUnit()
    {
        return $this->belongsTo(BusinessUnit::class);
    }

    public function userLog()
    {
        return $this->hasOne(UserLogin::class)->latest();
    }

    public function modelHasRole()
    {
        return $this->hasMany(ModelHasRole::class, 'model_id', 'id');
    }

    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function hasRoleId($roleId): bool
    {
        return $this->modelHasRole()->where('role_id', $roleId)->exists();
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'user_has_permissions', 'user_id', 'permission_id')
        ->withPivot('brand_id', 'permission_type')
        ->as('pivot');
    }

}
