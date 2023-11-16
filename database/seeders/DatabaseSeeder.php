<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Document;
use App\Models\DocumentPermission;
use App\Models\Metadata;
use App\Models\Profile;
use App\Models\Revision;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Metadata::factory(30)->create();
        Document::factory(20)->create();
        DocumentPermission::factory(5)->create();
        Profile::factory(15)->create();
        Revision::factory(10)->create();
        User::factory(15)->create();
    }
}
