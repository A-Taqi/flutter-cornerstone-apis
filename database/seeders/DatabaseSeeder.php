<?php

namespace Database\Seeders;

use App\Models\Project2\Employee;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $p2_manager = User::factory()->create([
            'email' => 'manager@tasky.com',
            'role' => 'manager',
            'password' => bcrypt('manager'),
        ]);
        $p2_manager_employee = new Employee();
        $p2_manager_employee->name = 'Manager';
        $p2_manager_employee->skills = ['management'];
        $p2_manager_employee->user_id = $p2_manager->id;
        $p2_manager_employee->save();
    }
}
