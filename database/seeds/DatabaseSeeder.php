<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);

      $faker = Faker::create();

      
       foreach(range(1,10) as $index)
       {
           DB::table('donors')->insert([
               'event_id'=>1,
               'name'=>$faker->name,
               'email'=>$faker->email,
               'phone'=>$faker->phoneNumber,
           ]);
        }

        foreach(range(1,10) as $index)
       {
           DB::table('items')->insert([
              'event_id'=>1,
              'donor_id'=>1,
              'title'=>$faker->sentence(),
              'description'=>$faker->paragraph(),
              'value'=>$faker->ssn(),
              'initial_bid'=>15,
              'increment'=>2,
              'current_bidder'=>0,
              'current_bid'=>0,
               'sold'=>false,
               'letter_sent'=>false
           ]);
        }
     }
}
