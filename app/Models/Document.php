<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'path'
    ];

    public function revisions()
    {
        $this->belongsToMany(Document::class);
    }

    public function permissions()
    {
        $this->hasMany(Permission::class);
    }

    public function metadata_types()
    {
        $this->belongsToMany(MetadataType::class);
    }

    public function file_links()
    {
        $this->hasOne(FileLink::class);
    }

}
