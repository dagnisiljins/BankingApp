<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investments extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'crypto_symbol', 'quantity', 'purchase_rate', 'status', 'sale_value'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
