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
    Schema::create('cash_registers', function (Blueprint $table) {
        $table->id();
        $table->string('status')->default('open'); // open, closed
        $table->integer('modal_awal')->default(0);
        $table->integer('total_tunai')->default(0);
        $table->integer('uang_fisik')->default(0);
        $table->integer('selisih')->default(0);
        $table->timestamp('opened_at')->useCurrent();
        $table->timestamp('closed_at')->nullable();
        $table->timestamps();
    });
}
};