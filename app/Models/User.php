<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Project1\Subscription;
use App\Models\Project2\Employee;
use App\Models\Project2\LeaveRequest;
use App\Models\Project2\Notification;
use App\Models\Project2\Task;
use App\Models\Project3\Account;
use App\Models\Project3\Card;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function p2_tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function p2_notifications() {
        return $this->hasMany(Notification::class);
    }

    public function p2_leave_requests() {
        return $this->hasMany(LeaveRequest::class);
    }

    public function p2_employee(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Employee::class);
    }

    public function p1_subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function p3_accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function p3_cards()
    {
        return $this->hasMany(Card::class);
    }
}
