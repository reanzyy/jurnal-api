<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolAdvisor extends Model
{
    protected $fillable = [
        'identity',
        'name',
        'phone',
        'address',
        'gender',
        'user_id',
        'password_hint',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
