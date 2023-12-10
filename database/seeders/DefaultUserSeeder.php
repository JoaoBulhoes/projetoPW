<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $user = User::create([
            'name' => 'a',
            'email' => "a@a",
            'password' => bcrypt('123456789'),
            'email_verified_at' => Carbon::now(),
        ]);

        $user->profiles()->attach(1);

    }
}
