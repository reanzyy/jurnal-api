<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternshipCompetency extends Model
{
    protected $fillable = [
        'internship_id',
        'competency',
        'description',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }
}
