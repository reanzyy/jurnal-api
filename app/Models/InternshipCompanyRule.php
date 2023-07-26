<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternshipCompanyRule extends Model
{
    protected $fillable = [
        'internship_id',
        'sequence',
        'description',
    ];

    public function Internship()
    {
        return $this->belongsTo(Internship::class);
    }
}

