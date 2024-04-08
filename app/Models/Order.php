<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illumiante\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'is_paid',
        'payment_receipt'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    // setelah perubahan adanya tabel transaction
    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

    // sebelum dirubah menjadi transaction, model `order` ini sebelumnya adalah sebagai berikut
    // public function products() {
    //     return $this->belongsToMany(Product::class);
    // }
}
