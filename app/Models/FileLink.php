<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'uid',
        'expiration_date',
        'document_id'
    ];

    public function document()
    {
        $this->belongsToMany(Document::class);
    }

}
