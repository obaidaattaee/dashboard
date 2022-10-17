<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceSubscription extends Model
{
    protected $table = 'invoice_subscription';

    protected $guarded = ['id'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscription_id', 'id');
    }
}
