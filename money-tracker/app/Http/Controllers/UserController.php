<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Rules\ValidEmail;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

class UserController extends Controller
{
    
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'  => 'required|string|max:255|min:2|regex:/^[a-zA-Z\s\-\.]+$/',
                'email' => ['required', 'email', 'unique:users,email', new ValidEmail()],
            ]);

            $user = User::create($validated);

            return $this->apiResponse($user, 'User created successfully', 201);
            
        } catch (ValidationException $e) {
            return $this->apiResponse(null, 'Validation failed: ' . $e->getMessage(), 422);
        } catch (Exception $e) {
            return $this->handleApiException($request, $e);
        }
    }

    public function show($id)
    {
        try {
            $user = User::findOrFail($id);

            $wallets = $user->wallets;

            $walletData = $wallets->map(function ($wallet) {
                return [
                    'id'      => $wallet->id,
                    'name'    => $wallet->name,
                    'balance' => $wallet->balance,
                ];
            });

            $totalBalance = $walletData->sum('balance');

            $userData = [
                'id'            => $user->id,
                'name'          => $user->name,
                'email'         => $user->email,
                'wallets'       => $walletData,
                'total_balance' => $totalBalance,
            ];

            return $this->apiResponse($userData, 'User profile retrieved successfully');
            
        } catch (ModelNotFoundException $e) {
            return $this->apiResponse(null, 'User not found', 404);
        } catch (Exception $e) {
            return $this->handleApiException($request, $e);
        }
    }
}
