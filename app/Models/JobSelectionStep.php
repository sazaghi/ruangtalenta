<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobSelectionStep extends Model
{
        protected $fillable = ['post_kerja_id', 'selection_method_id'];
    
        public function PostKerja()
        {
            return $this->belongsTo(PostKerja::class);
        }
    
        public function selectionMethod()
        {
            return $this->belongsTo(SelectionMethod::class);
        }
}
