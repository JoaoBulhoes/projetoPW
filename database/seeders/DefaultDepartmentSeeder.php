<?php

namespace Database\Seeders;

use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DefaultDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Department::create([
            'name' => 'Contabilidades',
        ]);

        Department::create([
            'name' => 'Markting',
        ]);

        Department::create([
            'name' => 'Administração',
        ]);

        Department::create([
            'name' => 'Informática',
        ]);

    }
}
