<?php

namespace App\Models\Project2;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'p2_tasks';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
