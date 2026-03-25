<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Model
{
    use HasUuids;
    
    // $fillable lists the columns that can be mass-assigned
    // (i.e. filled via User::create([...]))
    protected $fillable = ['name', 'email'];
    protected $keyType = 'string';
    public $incrementing = false;

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
