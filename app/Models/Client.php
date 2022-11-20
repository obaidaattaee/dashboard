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
            return $query->where('company_name', 'like', '%' . $name . '%')
                ->orWhere('admin_name', 'like', '%' . $name . '%');
        })->when(request()->input('email', false), function ($query, $email) {
            return $query->where('email', 'like', '%' . $email . '%');
        })->when(request()->input('phone_number', false), function ($query, $phoneNumber) {
            return $query->where('company_phone', 'like', '%' . $phoneNumber . '%')
                ->orWhere('admin_phone', 'like', '%' . $phoneNumber . '%');
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
