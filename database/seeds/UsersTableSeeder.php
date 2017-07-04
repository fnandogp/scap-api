<?php

use App\User;
use Illuminate\Database\Seeder;

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
            'name'       => 'Fernando Pinheiro',
            'email'      => 'fnandogp@gmail.com',
            'password'   => Hash::make('secret'),
            'enrollment' => '2010101656'
        ]);
    }
}
