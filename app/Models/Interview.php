<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_kerjas_id',
        'tipe',
        'metode',
        'jadwal',
        'link',
        'notes',
        'status',
        'result_note',
        'selection_template_id'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function postKerja()
    {
        return $this->belongsTo(PostKerja::class, 'post_kerjas_id');
    }
    public function selectionTemplate()
    {
        return $this->belongsTo(SelectionTemplate::class);
    }

}
