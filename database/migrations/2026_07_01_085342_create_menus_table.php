<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up() {
    Schema::create('menus', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->integer('price');
        $table->integer('stock'); // Ini kolom stok kita
        $table->string('category');
        $table->timestamps();
    });
}
};
