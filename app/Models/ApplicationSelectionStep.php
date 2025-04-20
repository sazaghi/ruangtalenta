<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationSelectionStep extends Model
{
    protected $fillable = ['lamaran_id', 'job_selection_step_id', 'scheduled_at', 'link', 'status'];

    public function lamaran()
    {
        return $this->belongsTo(Lamaran::class);
    }

    public function jobSelectionStep()
    {
        return $this->belongsTo(JobSelectionStep::class);
    }
}
