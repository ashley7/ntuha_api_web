<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $saveUser = new User();
        $saveUser->name = "Admin";
        $saveUser->email = "ntuharide@gmailcom";
        $saveUser->password = \Hash::make("admin123");
        $saveUser->remember_token = str_random(32);
        $saveUser->save();
    }
}
