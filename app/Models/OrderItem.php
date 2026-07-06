<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    // Tambahkan 'menu_name' di bawah ini
    protected $fillable = [
        'order_id', 
        'menu_id', 
        'menu_name', // <-- WAJIB TAMBAHKAN BARIS INI!
        'price', 
        'quantity', 
        'note'
    ];
}