<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        //User::create([
         \App\Models\User::factory()->create([
             "name" => "fadiyah",
             "email" => "diyahh@gmail.com",
             "password" => Hash::make('iyya')
           ]);
    }
}
