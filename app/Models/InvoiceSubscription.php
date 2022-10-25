<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceSubscription extends Model
{
    protected $table = 'invoice_subscription';

    protected $guarded = ['id'];

    const STATUSES = [
        [
            'id' => 1,
            'name' => 'pending',
            'color' => 'warning'
        ],
        [
            'id' => 2,
            'name' => 'called',
            'color' => 'info'
        ],
        [
            'id' => 3,
            'name' => 'renewd',
            'color' => 'success'
        ]
    ];
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id', 'id');
    }

    public function getSalesStatusNameAttribute()
    {
        $duration = collect(self::STATUSES)->where('id' , $this->getAttribute('sales_status'))->first();
        if ($duration) {
            return $duration['name'];
        }
        return self::STATUSES[0]['name'];
    }

    public function getSalesStatusColorAttribute()
    {
        $duration = collect(self::STATUSES)->where('id' , $this->getAttribute('sales_status'))->first();
        if ($duration) {
            return $duration['color'];
        }
        return self::STATUSES[0]['color'];
    }
}
