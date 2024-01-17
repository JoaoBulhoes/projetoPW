<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Department;
use App\Models\Document;
use App\Models\FileLink;
use App\Models\MetadataType;
use App\Models\Permission;
use App\Models\Profile;
use App\Models\Revision;
use App\Models\User;
use Grpc\Call;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

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

        if (App::environment() == 'local') {
            $this->call(AdminProfileSeeder::class);
            $this->call(DefaultUserSeeder::class);

            User::factory(30)->create();
            Document::factory(30)->create();
            Revision::factory(30)->create();
            Permission::factory(30)->create();
            Department::factory(30)->create();
            Profile::factory(30)->create();
            FileLink::factory(30)->create();

            $this->call(DefaultMetadataTypeSeeder::class);
            MetadataType::factory(30)->create();
        }
    }
}
