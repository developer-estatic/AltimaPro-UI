<?php

namespace App\Observers;

use App\Models\Smtp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class CreatedAndUpdatedByObserver
{
    public function creating(Model $model)
    {
        $model->created_by = Auth::user()?->id;
        $model->updated_by = Auth::user()?->id;
    }

    public function updating(Model $model)
    {
        $model->updated_by = Auth::user()?->id;
    }
}
