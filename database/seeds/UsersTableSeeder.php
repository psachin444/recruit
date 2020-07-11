<?php

use Illuminate\Database\Seeder;

use App\User;

use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
        	'first_name' => 'Sachin',
        	'last_name' => 'Patel',
        	'email' => 'admin@recruit.com',
        	'password' => Hash::make('1234')
        ]);
    }
}
