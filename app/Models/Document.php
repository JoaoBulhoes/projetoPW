<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'path'
    ];

    public function revisions()
    {
        return $this->belongsToMany(Document::class);
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }

    public function metadataTypes()
    {
        return $this->belongsToMany(MetadataType::class);
    }

    public function file_links()
    {
        return $this->hasOne(FileLink::class);
    }

}
