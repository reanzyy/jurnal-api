<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyAdvisor extends Model
{
    protected $fillable = [
        'company_id',
        'identity',
        'name',
        'phone',
        'gender',
        'user_id',
        'password_hint',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'id', 'company_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

