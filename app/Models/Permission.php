<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'read',
        'modify',
        'delete',
        'download',
        'document_id',
        'user_id'
    ];

    public function document()
    {
        $this->belongsTo(Document::class);
    }

}
