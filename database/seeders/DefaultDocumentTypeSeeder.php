<?php

namespace Database\Seeders;

use App\Models\Document;
use App\Models\MetadataType;
use App\Services\DocumentService;
use Illuminate\Database\Seeder;

class DefaultDocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $document = Document::create([
            'path' => fake()->filePath(),
        ]);

        DocumentService::setMainAtributes($document, fake()->name(), fake()->fileExtension());
    }
}
