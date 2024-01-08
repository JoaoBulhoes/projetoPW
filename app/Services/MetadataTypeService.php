<?php

namespace App\Services;

use App\Models\MetadataType;

class MetadataTypeService
{
    public function createMetadataType(string $name): MetadataType
    {
        return MetadataType::create([
            "name" => $name,
        ]);
    }
}
