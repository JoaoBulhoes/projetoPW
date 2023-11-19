<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdministrativeMetadata extends Model
{
    use HasFactory;

    protected $fillable = [
        'action_type',
        'datetime',
        'document_id',
        'user_id'
    ];

    public function document(){
        return $this->belongsTo(Document::class);
    }
}
