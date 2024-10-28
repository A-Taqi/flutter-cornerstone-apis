<?php

namespace App\Models\Project2;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $table = 'p2_leave_requests';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
