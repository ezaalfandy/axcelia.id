<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            "name" => "ezaalfandy",
            "email" => "ezaalfandy.ea@gmail.com",
            'email_verified_at' => now(),
            "password" => Hash::make("password")
        ]);

        DB::table('admins')->insert([
            "name" => "Admin",
            "email" => "Admin@axcelia.id",
            'email_verified_at' => now(),
            "password" => Hash::make("password")
        ]);
    }
}
