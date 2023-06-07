<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        foreach(range(1,50) as $index)
        {
            $data = [
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName, // make sure you create first_name and last_name first in the db, then seed
                'email' => $faker->email,
                'password' => bcrypt("pass123"),
            ];
            // create admin
            User::create($data);
        }
    }
}
