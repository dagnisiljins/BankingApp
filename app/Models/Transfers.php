<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfers extends Model
{
    use HasFactory;
    protected $fillable = [
        'from_account',
        'to_account',
        'sent_amount',
        'received_amount',
        'sent_currency',
        'received_currency',
        'payment_reference'
    ];
}
