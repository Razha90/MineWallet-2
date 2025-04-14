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
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column: 'product_id')->constrained('product_merchant');
            $table->foreignId(column: 'user_id')->constrained('users');
            $table->string('type');
            $table->string('sub_type');
            $table->string('service_name')->nullable();
            $table->string('prize')->nullable();
            $table->string('quantity')->nullable();
            $table->string('total')->nullable();
            $table->enum('status', ['waiting', 'pending', 'approved', 'rejected'])->default('waiting');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};
