<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use App\Models\Member;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \Illuminate\Database\Eloquent\Model::unguard();

        // 1. Create Admins
        $users = [
            ['username' => 'superadmin', 'first_name' => 'John', 'last_name' => 'Wick', 'email' => 'admin@sdachurch.com', 'role' => 'Super Admin'],
            ['username' => 'pastor', 'first_name' => 'David', 'last_name' => 'Miller', 'email' => 'pastor@sdachurch.com', 'role' => 'Pastor'],
            ['username' => 'clerk', 'first_name' => 'Jane', 'last_name' => 'Doe', 'email' => 'clerk@sdachurch.com', 'role' => 'Clerk'],
            ['username' => 'treasurer', 'first_name' => 'Mike', 'last_name' => 'Johnson', 'email' => 'treasurer@sdachurch.com', 'role' => 'Treasurer'],
            ['username' => 'head_elder', 'first_name' => 'Samuel', 'last_name' => 'Wilson', 'email' => 'elder@sdachurch.com', 'role' => 'Head Elder'],
        ];

        foreach ($users as $user) {
            User::create([
                'username' => $user['username'],
                'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'email' => $user['email'],
                'password' => Hash::make('password123'),
                'role' => $user['role'],
            ]);
        }

        $departments = [
            'Sabbath School',
            'Adventist Youth',
            'Women\'s Ministries',
            'Men\'s Ministries',
            'Personal Ministries',
            'Health Ministries',
            'Children\'s Ministries',
            'Music / Choir',
            'Elders',
            'Deacons & Deaconesses',
        ];

        foreach ($departments as $dept) {
            Department::create(['name' => $dept, 'description' => $dept . ' Department']);
        }

        // 3. Create sample members
        Member::create([
            'first_name' => 'Alice',
            'last_name' => 'Williams',
            'date_of_birth' => '1985-04-12',
            'gender' => 'Female',
            'contact_number' => '555-0101',
            'email' => 'alice@email.com',
            'address' => '123 Elm St, City',
            'baptism_date' => '2000-05-20',
            'status' => 'Active',
        ]);

        Member::create([
            'first_name' => 'Bob',
            'last_name' => 'Brown',
            'date_of_birth' => '1990-08-25',
            'gender' => 'Male',
            'contact_number' => '555-0102',
            'email' => 'bob@email.com',
            'address' => '456 Oak Ave, City',
            'baptism_date' => '2010-09-15',
            'status' => 'Active',
        ]);
        
        Member::create([
            'first_name' => 'Charlie',
            'last_name' => 'Davis',
            'date_of_birth' => '1975-11-03',
            'gender' => 'Male',
            'contact_number' => '555-0103',
            'email' => 'charlie@email.com',
            'address' => '789 Pine Rd, City',
            'baptism_date' => '1995-12-01',
            'status' => 'Transferred',
        ]);
    }
}
