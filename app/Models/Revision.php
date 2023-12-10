<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Revision extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'path',
        'document_id'
    ];

    public function document(){
        $this->hasOne(Document::class);
    }
}
