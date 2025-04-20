<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bio extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'full_name',
        'contact_number',
        'website',
        'bio',
        'experience',
        'education_level',
        'facebook',
        'twitter',
        'instagram',
        'avatar',
        'skills',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function getCompletionPercentageAttribute()
    {
        $fields = [
            'full_name',
            'contact_number',
            'website',
            'bio',
            'experience',
            'education_level',
            'facebook',
            'twitter',
            'instagram',
            'avatar',
        ];

        $filled = 0;
        foreach ($fields as $field) {
            if (!empty($this->$field)) {
                $filled++;
            }
        }

        return round(($filled / count($fields)) * 100);
    }

    
}
    