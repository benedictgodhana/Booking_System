<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Benedict Godhana',
                'email' => 'bdhadho@strathmore.edu',
                'role' => '1',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'activation_token' => Str::random(60),
                'activated' => true, // or false if not activated
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'department' => 'IT Support',
                'is_guest' => 0, // 0 for regular user, 1 for guest
                'first_login' => true, // or false if not first login
            ],

            [
                'name' => 'Patrick Wachira',
                'email' => 'pwmbuthia@strathmore.edu',
                'role' => '1',
                'email_verified_at' => now(),
                'password' => Hash::make('password123'),
                'activation_token' => Str::random(60),
                'activated' => true, // or false if not activated
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'department' => 'IT Support',
                'is_guest' => 0, // 0 for regular user, 1 for guest
                'first_login' => true, // or false if not first login
            ],
            // Add more user records as needed
        ];

        // Insert the seed data into the users table
        User::insert($users);
    }
    }

