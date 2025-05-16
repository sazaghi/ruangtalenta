<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectionTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_kerjas_id',
        'stage_name',
        'stage_order',
    ];

    public function postKerja()
    {
        return $this->belongsTo(PostKerja::class, 'post_kerjas_id');
    }
}
