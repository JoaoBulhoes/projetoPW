<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentPermission extends Model
{
    use HasFactory, SoftDeletes;

    public function User(){
        return $this->hasOne(User::class);
    }

    public function Document(){
        return $this->belongsTo(Document::class);
    }
}
