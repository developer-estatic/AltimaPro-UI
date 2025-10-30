<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    use HasFactory;

    protected $table = 'user_logins';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'user_ip',
        'longitude',
        'latitude',
        'city',
        'country',
        'country_code',
        'browser',
        'os',
        'browser',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

}
