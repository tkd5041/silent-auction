<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       User::truncate();
       DB::table('role_user')->truncate();

        $adminRole = Role::where('name', 'admin')->first();
 //     $authorRole = Role::where('name', 'author')->first();
        $userRole = Role::where('name', 'user')->first();

        $admin = User::create([
            'name' => 'Admin User',
            'username' => 'superman',
            'email' => 'admin@admin.com',
            'phone' => '6023493385',
            'email_verified_at' => '2020-08-04 19:19:30',
            'password' => Hash::make('asdfasdf') 
        ]);
/*
        $author = User::create([
            'name' => 'Author User',
            'email' => 'author@author.com',
            'password' => Hash::make('asdfasdf') 
        ]);
*/
        $user = User::create([
            'name' => 'Generic User',
            'username' => 'genericman',
            'email' => 'user@user.com',
            'phone' => '6025551212',
            'email_verified_at' => '2020-08-04 19:19:30',
            'password' => Hash::make('asdfasdf') 
        ]);

        $admin->roles()->attach($adminRole);
//      $author->roles()->attach($authorRole);
        $user->roles()->attach($userRole);
    }
}
