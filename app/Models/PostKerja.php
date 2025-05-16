<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostKerja extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'location',
        'salary_min', 
        'salary_max',
        'selection_methods',
        'experience',
        'job_type',
        'skills',
        'deadline',
        'category_id'
    ];

    protected $casts = [
        'skills' => 'array',
        'selection_methods' => 'array', // Mengubah JSON ke array saat diambil dari DB
    ];

    /**
     * Relasi ke Company (Perusahaan yang membuat job)
     */
    public function company()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke JobRequirement (Satu Job bisa punya banyak Requirement)
     */
    public function requirements()
    {
        return $this->hasMany(MPostKerjaSkill::class, 'm_postkerja_id');
    }

    /**
     * Relasi ke Application (Melacak siapa saja yang melamar pekerjaan ini)
     */
    public function Lamarans()
    {
        return $this->hasMany(Lamaran::class, 'post_kerjas_id');
    }
    public function selectionSteps()
    {
        return $this->hasMany(JobSelectionStep::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function selectionTemplates()
    {
        return $this->hasMany(SelectionTemplate::class, 'post_kerjas_id');
    }
}
