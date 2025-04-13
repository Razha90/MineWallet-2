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
        Schema::create('product_merchant', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['product', 'service']);
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('image')->nullable();
            $table->string('price')->nullable();
            $table->string('quantity')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_merchant');
    }
};
