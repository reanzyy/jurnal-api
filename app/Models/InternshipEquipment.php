<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InternshipEquipment extends Model
{
    protected $table = "internship_equipments";

    protected $fillable = [
        'internship_id',
        'tool',
        'specification',
        'utility',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }
}
