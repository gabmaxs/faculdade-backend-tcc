<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $profile = [
            "culinary_level" => 4,
            "gender" => "M",
            "user_id" => 1
        ];

        Profile::create($profile);
    }
}
