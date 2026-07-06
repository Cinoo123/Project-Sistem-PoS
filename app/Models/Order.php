<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Tambahkan 'order_number' di bawah ini agar diizinkan Laravel untuk disimpan
    protected $fillable = [
        'order_number', // <-- WAJIB ditambahkan ke properti fillable!
        'order_type', 
        'payment_method', 
        'subtotal', 
        'discount_amount', 
        'tax_amount', 
        'total_amount',
        'status'
    ];

    // Relasi ke Order Items
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}