<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('wallet_id');
            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
            $table->enum('type', ['income', 'expense']);
            $table->decimal('amount', 10, 2);
            $table->text('description')->nullable();
            $table->timestamps();
            
            // Add indexes for performance
            $table->index(['wallet_id', 'type']);
            $table->index(['wallet_id', 'created_at']);
            $table->index('type');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
