<?php

namespace App\Models\Project3;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'p3_accounts';

    public function card()
    {
        return $this->hasOne(Card::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
