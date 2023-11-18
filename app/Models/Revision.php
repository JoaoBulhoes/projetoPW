<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'document_id'
    ];

    public function document(){
        $this->hasOne(Document::class);
    }
}
