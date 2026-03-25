<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Transaction extends Model
{
    use HasUuids;
    
    protected $fillable = ['wallet_id', 'type', 'amount', 'description'];
    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * Each transaction belongs to one wallet.
     * Usage: $transaction->wallet
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
