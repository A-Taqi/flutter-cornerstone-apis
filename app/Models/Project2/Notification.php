<?php

namespace App\Models\Project2;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'p2_notifications';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
