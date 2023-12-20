<?php

namespace App\Services;

use App\Models\MetadataType;
use Illuminate\Support\Facades\Auth;

class MetadataTypeService
{
    public function createMetadataType(string $name): MetadataType
    {
        return MetadataType::create([
            "name" => $name,
        ]);
    }
}
