<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class TopUp extends Model
{
    use HasUuids;
    
    protected $table = 'topup';

    protected $fillable = [
        'id',
        'bank_id',
        'user_id',
        'amount',
        'admin',
        'status',
        'image',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
