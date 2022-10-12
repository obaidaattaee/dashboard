<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function scopeTableFilter($query)
    {
        return $query->when(request()->input('name', false), function ($query, $name) {
            return $query->where('name', 'like', '%' . $name . '%');
        });
    }

    public function logo()
    {
        return $this->belongsTo(Attachment::class, 'logo_id', 'id');
    }

    public function getLogoImageAttribute()
    {
        return object_get($this, 'logo.full_path', asset('admin_assets/assets/icons/at.svg'));
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class, 'client_id', 'id');
    }
}
