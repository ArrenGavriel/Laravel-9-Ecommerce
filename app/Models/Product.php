<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'image',
        'stock'
    ];
    
    // sebelum perubahan transaction:
    // public function orders() {
    //     return $this->belongsToMany(Order::class);
    // }
    
    // setelah perubahan transaction
    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

    public function carts() {
        return $this->hasMany(Cart::class);
    }
}
