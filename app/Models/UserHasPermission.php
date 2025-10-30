<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\CreatedAndUpdatedByObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([CreatedAndUpdatedByObserver::class])]
class UserHasPermission extends Model
{
    protected $table = 'user_has_permissions';

    protected $fillable = [
        'user_id',
        'brand_id',
        'permission_id',
        'permission_type',
        'created_by',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_has_permissions', 'user_id', 'permission_id')
            ->withPivot('brand_id', 'permission_type', 'created_by', 'updated_by')
            ->using(UserHasPermission::class);
    }
}
