<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    const STATUSES = [
        [
            'id' => 1,
            'name' => 'pending',
            'color' => 'warning',
        ],
        [
            'id' => 2,
            'name' => 'paid',
            'color' => 'success',
        ],
        [
            'id' => 3,
            'name' => 'ends',
            'color' => 'danger',
        ]
    ];

    public function getStatusNameAttribute()
    {
        return object_get(collect(self::STATUSES)->where('id', $this->getAttribute('status'))->first(), 'name', self::STATUSES[0]['name']);
    }

    public function getStatusColorAttribute()
    {
        return object_get(collect(self::STATUSES)->where('id', $this->getAttribute('status'))->first(), 'color', self::STATUSES[0]['color']);
    }

    public function scopeTableFilter($query)
    {
        return $query->when(request()->input('clinet_id', false), function ($query, $clientId) {
            return $query->where('client_id', $clientId);
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'invoice_subscription', 'subscription_id', 'invoice_id');
    }

    public function invoiceSubscriptions()
    {
        return $this->hasMany(InvoiceSubscription::class , 'subscription_id')->latest();
    }
}
