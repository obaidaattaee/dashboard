<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class automation_notification extends Model
{
    use HasFactory;
    protected $fillable =[
        'subscription_id',
        'end_date'
        ];
}
