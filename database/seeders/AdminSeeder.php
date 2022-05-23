<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::whereEmail('admin@admin.com')->delete();
       $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('@dmin123#'),
            'api_token' => Str::random(60),
        ]);
        $token = $user->createToken('Laravel Password Grant Client')->accessToken;


    }
}
