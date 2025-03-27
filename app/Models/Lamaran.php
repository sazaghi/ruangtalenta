<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lamaran extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'post_kerjas_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function PostKerja()
    {
        return $this->belongsTo(PostKerja::class, 'post_kerjas_id');
    }
}
