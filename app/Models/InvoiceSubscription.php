<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceSubscription extends Model
{
    protected $table = 'invoice_subscription';

    protected $guarded = ['id'];
}
