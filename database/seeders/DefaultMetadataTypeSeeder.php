<?php

namespace Database\Seeders;

use App\Models\MetadataType;
use App\Models\User;
use Illuminate\Database\Seeder;

class DefaultMetadataTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $metadatatype = metadatatype::create([
            'name' => 'name',
        ]);
        $metadatatype->save();

        $metadatatype = metadatatype::create([
            'name' => 'extension',
        ]);
        $metadatatype->save();
    }
}
