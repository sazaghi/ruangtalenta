<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MPostKerjaSkill extends Model
{
    use HasFactory;

    protected $fillable = [
        'm_postkerja_id',
        'required_skills',
        'min_experience',
        'education_level'
    ];

    public function postkerja()
    {
        return $this->belongsTo(MPostKerja::class);
    }
}
