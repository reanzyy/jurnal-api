<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'internship_id',
        'since',
        'sectors',
        'services',
        'address',
        'telephone',
        'email',
        'website',
        'director',
        'director_phone',
        'advisors',
        'structure',
    ];

    protected $casts = [
        'sectors' => 'array',
        'services' => 'array',
        'advisors' => 'array',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }
}
