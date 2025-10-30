<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use App\Observers\CreatedAndUpdatedByObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
#[ObservedBy([CreatedAndUpdatedByObserver::class])]
class Role extends SpatieRole
{
    protected $fillable = [
        'name',
        'guard_name',
        'parent_id'
    ];

    public function assignedUsers()
    {
        return $this->belongsToMany(User::class, 'model_has_roles', 'role_id', 'model_id');
    }

    public function parent()
    {
        return $this->belongsTo(Role::class, 'parent_id');
    }
    public function children()
    {
        return $this->hasMany(Role::class, 'parent_id');
    }
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions', 'role_id', 'permission_id')
        ->withPivot('brand_id', 'permission_type')
        ->as('pivot');
    }
}
