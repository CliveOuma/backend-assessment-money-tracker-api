<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = ['user_id', 'name'];

    /**
     * Each wallet belongs to one user.
     * Usage: $wallet->user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A wallet has many transactions.
     * Usage: $wallet->transactions
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Computed balance: sum income, subtract expenses.
     * This is a custom accessor — not stored in DB.
     * Usage: $wallet->balance
     */
    public function getBalanceAttribute()
    {
        $income  = $this->transactions()->where('type', 'income')->sum('amount');
        $expense = $this->transactions()->where('type', 'expense')->sum('amount');
        return $income - $expense;
    }
}
