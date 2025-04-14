<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table = 'bank';

    protected $fillable = [
        'name',
        'account_number',
        'account_name',
        'admin',
        'image',
        'type',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'bank_id');
    }

    public function topups()
    {
        return $this->hasMany(TopUp::class, 'bank_id');
    }

    public function transfers()
    {
        return $this->hasMany(Transfer::class, 'bank_id');
    }
}
