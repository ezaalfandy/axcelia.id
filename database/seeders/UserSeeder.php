<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('users')->insert([
            "name" => "client",
            "email" => "client@gmail.com",
            'email_verified_at' => now(),
            "password" => Hash::make("password"),
            "phone_number" => 981231213,
            "province" => "jawa timur",
            "city" => "kab. Mojokerto",
            "address" => "puri",
            "zip_code" => "61363"
        ]);
    }
}
