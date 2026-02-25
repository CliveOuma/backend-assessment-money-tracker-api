<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    // $fillable lists the columns that can be mass-assigned
    // (i.e. filled via User::create([...]))
    protected $fillable = ['name', 'email'];

    /**
     * A user can have many wallets.
     * This creates a hasMany relationship.
     * Usage: $user->wallets
     */
    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }
}
