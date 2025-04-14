<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductMerchant extends Model
{
    protected $table = 'product_merchant';
    protected $fillable = [
        'type',
        'sub_type',
        'name',
        'discount',
        'description',
        'image',
        'price',
        'quantity'
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'product_id');
    }
}
