<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Http\Rules\ValidAmount;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

class TransactionController extends Controller
{
   
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'wallet_id'   => 'required|string|uuid|exists:wallets,id',
                'type'        => 'required|in:income,expense',
                'amount'      => ['required', new ValidAmount()],
                'description' => 'nullable|string|max:500|regex:/^[a-zA-Z0-9\s\-\.\,\&\(\)]+$/',
            ]);

            // Check for potential duplicate transaction (same wallet, type, amount, description within last 5 minutes)
            $recentDuplicate = Transaction::where('wallet_id', $validated['wallet_id'])
                ->where('type', $validated['type'])
                ->where('amount', $validated['amount'])
                ->where('description', $validated['description'] ?? '')
                ->where('created_at', '>', now()->subMinutes(5))
                ->first();

            if ($recentDuplicate) {
                return $this->apiResponse(null, 'Duplicate transaction detected', 422);
            }

            $transaction = Transaction::create($validated);

            return $this->apiResponse($transaction, 'Transaction created successfully', 201);
            
        } catch (ValidationException $e) {
            return $this->apiResponse(null, 'Validation failed: ' . $e->getMessage(), 422);
        } catch (Exception $e) {
            return $this->handleApiException($request, $e);
        }
    }

}
