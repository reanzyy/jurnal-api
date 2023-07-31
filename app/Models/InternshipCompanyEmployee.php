<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternshipCompanyEmployee extends Model
{
    protected $fillable = [
        'internship_id',
        'job_title_id',
        'name',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }

    public function jobTitle()
    {
        return $this->belongsTo(InternshipCompanyJobTitle::class, 'job_title_id');
    }
}
