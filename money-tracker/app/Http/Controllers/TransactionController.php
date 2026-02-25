<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
   
    public function store(Request $request)
    {
        $validated = $request->validate([
            'wallet_id'   => 'required|integer|exists:wallets,id',
            'type'        => 'required|in:income,expense',
            'amount'      => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:500',
        ]);

        $transaction = Transaction::create($validated);

        return response()->json($transaction, 201);
    }

}
