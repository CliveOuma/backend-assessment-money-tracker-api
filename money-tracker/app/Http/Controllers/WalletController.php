<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

class WalletController extends Controller
{
    
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|string|uuid|exists:users,id',
                'name'    => 'required|string|max:255',
            ]);

            $wallet = Wallet::create($validated);

            return $this->apiResponse($wallet, 'Wallet created successfully', 201);
            
        } catch (ValidationException $e) {
            return $this->apiResponse(null, 'Validation failed: ' . $e->getMessage(), 422);
        } catch (Exception $e) {
            return $this->handleApiException($request, $e);
        }
    }

    public function show($id)
    {
        try {
            $wallet = Wallet::findOrFail($id);

            $transactions = $wallet->transactions;

            $walletData = [
                'id'           => $wallet->id,
                'name'         => $wallet->name,
                'balance'      => $wallet->balance,  
                'transactions' => $transactions,
            ];

            return $this->apiResponse($walletData, 'Wallet retrieved successfully');
            
        } catch (ModelNotFoundException $e) {
            return $this->apiResponse(null, 'Wallet not found', 404);
        } catch (Exception $e) {
            return $this->handleApiException($request, $e);
        }
    }
}
