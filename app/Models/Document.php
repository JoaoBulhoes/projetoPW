<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    public function Metadata(){
        return $this->hasMany(Metadata::class);
    }

    public function Revision(){
        return $this->belongsTo(Revision::class);
    }

    public function DocumentPermission(){
        return $this->hasMany(DocumentPermission::class);
    }

    public function User(){
        return $this->belongsTo(User::class);
    }
}
