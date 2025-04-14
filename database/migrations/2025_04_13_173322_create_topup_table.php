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
        Schema::create('topup', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('bank_id')->constrained('bank');
            $table->foreignId('user_id')->constrained('users');
            $table->string('amount');
            $table->string('admin');
            $table->enum('status', ['waiting','pending', 'success', 'failed'])->default('waiting');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('topup');
    }
};
