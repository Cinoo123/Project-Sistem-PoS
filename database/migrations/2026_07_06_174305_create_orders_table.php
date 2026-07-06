<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->string('order_type');
            $table->string('payment_method');
            $table->integer('subtotal');
            $table->integer('discount_amount')->default(0);
            $table->integer('tax_amount');
            $table->integer('total_amount');
            $table->integer('cash_received')->nullable(); // Ditulis nullable karena ada data NULL di foto kamu
            $table->integer('cash_change')->nullable();  // Ditulis nullable karena ada data NULL di foto kamu
            $table->string('status');
            $table->timestamps(); // Mengover created_at dan updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};