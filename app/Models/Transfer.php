<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasUuids;
    protected $table = 'transfer';

    protected $fillable = [
        'bank_id',
        'sender_id',
        'receiver_id',
        'amount',
        'phone',
        'status',
        'image',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
