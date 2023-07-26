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
        return $this->belongsTo(SchoolYear::class);
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
        return $this->belongsTo(SchoolAdvisor::class);
    }

    public function companyAdvisor()
    {
        return $this->belongsTo(CompanyAdvisor::class);
    }
}
