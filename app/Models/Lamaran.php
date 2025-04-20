<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lamaran extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'post_kerjas_id', 'status', 'tanggal_interview', 'link_meet','score'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function PostKerja()
    {
        return $this->belongsTo(PostKerja::class, 'post_kerjas_id');
    }
    // Di model Lamaran
    public function getMatchingInterview($interviews)
    {
        return $interviews->first(function ($interview) {
            return $interview->user_id === $this->user_id
                && $interview->post_kerjas_id === $this->post_kerjas_id;
        });
    }


}
