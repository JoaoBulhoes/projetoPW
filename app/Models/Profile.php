<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'create_user',
        'manage_user',
        'delete_user',
        'create_department',
        'delete_department',
        'access_admin_dashboard'
    ];

    public function users()
    {
        return $this->belongsToMany(Department::class);
    }
}
