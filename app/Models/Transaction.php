<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaction';
    protected $fillable = [
        'product_id',
        'user_id',
        'type',
        'sub_type',
        'service_name',
        'prize',
        'quantity',
        'total',
        'status',
        'approved_at',
        'rejected_at'
    ];

    public function product()
    {
        return $this->belongsTo(ProductMerchant::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
