<?php

namespace App\Models;

use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{


    public function scopeTableFilter($query)
    {
        return $query->when(request()->input('name', false), function ($query, $name) {
            return $query->where('name', 'like', '%' . $name . '%');
        });
    }
}
