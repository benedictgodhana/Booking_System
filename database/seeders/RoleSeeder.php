<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        $roles = [
            ['name' => 'users', 'id' => 0, 'created_at' => $now, 'updated_at' => $now], // Default role for users
            ['name' => 'SuperAdmin', 'id' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'SubAdmin', 'id' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Admin', 'id' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'MiniAdmin', 'id' => 4, 'created_at' => $now, 'updated_at' => $now],
            // Add more roles as needed
        ];
        DB::table('roles')->insert($roles);
    }
}
