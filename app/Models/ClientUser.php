<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientUser extends Model
{
    protected $table = 'client_users';

    public function crm_user()
    {
        return $this->hasOne(CRMUser::class, 'account_id', 'account_id');
    }
}
