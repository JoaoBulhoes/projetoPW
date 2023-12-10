<?php

namespace Database\Seeders;

use App\Models\Profile;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Profile::create([
            'name' => 'admin',
            'create_user' => '1',
            'manage_user' => '1',
            'delete_user' => '1',
            'create_department' => '1',
            'delete_department' => '1',
            'access_admin_dashboard' => '1'
        ]);
    }
}
