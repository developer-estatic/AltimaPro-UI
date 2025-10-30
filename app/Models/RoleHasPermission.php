<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\CreatedAndUpdatedByObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
#[ObservedBy([CreatedAndUpdatedByObserver::class])]
class RoleHasPermission extends Model
{
    protected $table = 'role_has_permissions';

    protected $fillable = [
        'role_id',
        'brand_id',
        'permission_id',
        'permission_type',
        'created_by',
        'updated_by',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
