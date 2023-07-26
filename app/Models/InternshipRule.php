<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternshipRule extends Model
{
    protected $fillable = [
        'school_year_id',
        'sequence',
        'description',
    ];

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYear::class);
    }
}

