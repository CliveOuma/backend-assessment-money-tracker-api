<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'name'    => 'required|string|max:255',
        ]);

        $wallet = Wallet::create($validated);

        return response()->json($wallet, 201);
    }

    public function show($id)
    {
        $wallet = Wallet::findOrFail($id);

        $transactions = $wallet->transactions;

        return response()->json([
            'id'           => $wallet->id,
            'name'         => $wallet->name,
            'balance'      => $wallet->balance,  
            'transactions' => $transactions,
        ]);
    }
}
