<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function invoiceImage()
    {
        return $this->belongsTo(Attachment::class , 'invoice_image' , 'id');
    }
}
