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
        'salary',
        'status', // Bisa 'open' atau 'closed'
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
    public function applications()
    {
        return $this->hasMany(Lamaran::class, 'post_kerjas_id');
    }

}
