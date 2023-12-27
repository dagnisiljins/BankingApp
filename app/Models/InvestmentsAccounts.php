<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestmentsAccounts extends Model
{
    use HasFactory;

    protected $primaryKey = 'account_no';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['user_id', 'balance'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($account) {
            $account->account_no = self::generateAccountNumber();
        });
    }

    private static function generateAccountNumber()
    {
        $lastAccount = self::latest('account_no')->first();
        $lastNumber = $lastAccount ? intval(substr($lastAccount->account_no, -5)) : 0;
        $newNumber = str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);
        return 'LV20INVEST' . $newNumber;
    }
}
