<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Observers\CreatedAndUpdatedByObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
#[ObservedBy([CreatedAndUpdatedByObserver::class])]
class ColumnMaster extends Model
{
    use HasFactory;

    protected $table = 'column_master';

    protected $fillable = [
        'name',
        'status',
        'es_name',
        'module_id',
        'sequence',
        'created_by',
        'updated_by',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }
}
