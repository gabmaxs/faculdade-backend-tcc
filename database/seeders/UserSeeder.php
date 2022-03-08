<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            "name" => "MyCook Team",
            "email" => "mycook@mycook.com",
            "password" => Hash::make("secret"),
        ];
        
        User::create($user);
    }
}
