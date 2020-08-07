<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create(
            [
                'name'=>'jose',
                'email'=>'jose@gmail.com',
                'password'=>bcrypt('josejose')
            ]
        );
    }
}
