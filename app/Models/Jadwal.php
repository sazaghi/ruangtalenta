<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $fillable = ['title', 'date', 'time', 'link', 'note', 'status', 'status_icon'];
}

