<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    
    public function store(Request $request)
    {
        // Validate incoming data
        $validated = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

    
        $user = User::create($validated);

        return response()->json($user, 201);
    }

   
    public function show($id)
    {
        $user = User::findOrFail($id);

        // Load all wallets for this user
        $wallets = $user->wallets;

        // Build wallet data including balance for each wallet
        $walletData = $wallets->map(function ($wallet) {
            return [
                'id'      => $wallet->id,
                'name'    => $wallet->name,
                'balance' => $wallet->balance,
            ];
        });

        // Calculate the total balance across ALL wallets
        $totalBalance = $walletData->sum('balance');

        return response()->json([
            'id'            => $user->id,
            'name'          => $user->name,
            'email'         => $user->email,
            'wallets'       => $walletData,
            'total_balance' => $totalBalance,
        ]);
    }
}
