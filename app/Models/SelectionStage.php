<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectionStage extends Model
{
    use HasFactory;

    protected $fillable = [
        'lamarans_id',
        'stage_name',
        'status',
        'order_index',
    ];

    public function lamaran()
    {
        return $this->belongsTo(Lamaran::class, 'lamarans_id');
    }
}
