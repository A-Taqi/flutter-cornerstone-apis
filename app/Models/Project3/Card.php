<?php

namespace App\Models\Project3;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'p3_cards';

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
