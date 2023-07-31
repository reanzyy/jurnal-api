<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    protected $fillable = [
        'school_year_id',
        'student_id',
        'company_id',
        'school_advisor_id',
        'company_advisor_id',
        'working_day',
    ];

    public function schoolYear()
    {
        return $this->hasMany(schoolYear::class, 'id', 'school_year_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function schoolAdvisor()
    {
        return $this->hasMany(SchoolAdvisor::class, 'id', 'school_advisor_id');
    }

    public function companyAdvisor()
    {
        return $this->belongsTo(CompanyAdvisor::class);
    }

    public function journals()
    {
        return $this->hasMany(InternshipJournal::class);
    }
}