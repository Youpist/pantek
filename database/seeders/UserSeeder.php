<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataUser = [
            [
                'name'=> 'admin',
                'email'=> 'admin@gmail.com',
                'role'=> 'admin',
                'password'=> bcrypt('admin'),
                'email_verified_at'=> now(),
                'remember_token'=> Str::random(10),
            ],
            [
                'name'=> 'bank',
                'email'=> 'bank@gmail.com',
                'role'=> 'bank',
                'password'=> bcrypt('bank'),
                'email_verified_at'=> now(),
                'remember_token'=> Str::random(10),
            ],
            [
                'name'=> 'kantin',
                'email'=> 'kantin@gmail.com',
                'role'=> 'kantin',
                'password'=> bcrypt('kantin'),
                'email_verified_at'=> now(),
                'remember_token'=> Str::random(10),
            ],
            [
                'name'=> 'customer',
                'email'=> 'customer@gmail.com',
                'role'=> 'customer',
                'password'=> bcrypt('customer'),
                'email_verified_at'=> now(),
                'remember_token'=> Str::random(10),
            ],
            ];
            foreach($dataUser as $key => $val){
                User::create($val);
            }
    }
}
