<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;
use App\Observers\CreatedAndUpdatedByObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
#[ObservedBy([CreatedAndUpdatedByObserver::class])]
class Permission extends SpatiePermission
{
    protected $fillable = [
        'name',
        'display_name',
        'module_id',
        'guard_name',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
