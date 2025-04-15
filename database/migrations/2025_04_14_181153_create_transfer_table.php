<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transfer', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('bank_id')->nullable()->constrained('bank');
            $table->foreignId('sender_id')->constrained('users');
            $table->string('receiver_id')->nullable();
            $table->string('amount');
            $table->string(column: 'phone')->nullable();
            $table->enum('status', ['waiting', 'pending', 'approved', 'failed'])->default('waiting');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer');
    }
};
