<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternshipJournal extends Model
{
    protected $fillable = [
        'internship_id',
        'date',
        'activity',
        'competency_id',
        'activity_image',
        'approval_user_id',
        'approval_by',
        'approval_at',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }

    public function competency()
    {
        return $this->belongsTo(InternshipCompetency::class);
    }

    public function approvalUser()
    {
        return $this->belongsTo(User::class, 'approval_user_id');
    }
}
