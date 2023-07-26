<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternshipSuggestion extends Model
{
    protected $fillable = [
        'internship_id',
        'company_employee_id',
        'suggest',
        'approval_user_id',
        'approval_by',
        'approval_at',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }

    public function companyEmployee()
    {
        return $this->belongsTo(InternshipCompanyEmployee::class, 'company_employee_id');
    }

    public function approvalUser()
    {
        return $this->belongsTo(User::class, 'approval_user_id');
    }
}

