<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Observers\CreatedAndUpdatedByObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([CreatedAndUpdatedByObserver::class])]
class Telegram extends Model
{
    protected $table = 'telegram';

    protected $fillable = [
        'name',
        'image_path',
        'bot_id',
        'status',
        'brand_id',
    ];
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
