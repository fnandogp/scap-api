<?php

use App\User;
use Illuminate\Database\Seeder;

class InitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'       => 'Admin',
            'email'      => 'admin@example.com',
            'password'   => bcrypt('secret'),
            'enrollment' => '0000000000'
        ]);
    }
}
