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
        'country', 
        'city', 
        'complete_address',
        'education',
        'work_experience'
    ];
    protected $casts = [
        'skills' => 'array',
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
            'country', 
            'city', 
            'complete_address'
        ];

        $fields = array_keys(self::getCompletionFields());
        $filled = 0;
        foreach ($fields as $field) {
            $value = $this->$field;

            if (!is_null($value) && trim($value) !== '') {
                $filled++;
            }
        }

        return round(($filled / count($fields)) * 100);
    }
    // app/Models/Bio.php

    public static function getCompletionFields()
    {
        return [
            'full_name' => 'full name',
            'contact_number' => 'phone number',
            'website' => 'website',
            'bio' => 'bio',
            'experience' => 'experience',
            'education_level' => 'education level',
            'facebook' => 'Facebook',
            'twitter' => 'Twitter',
            'instagram' => 'Instagram',
            'avatar' => 'profile picture',
            'country' => 'country',
            'city' => 'city',
            'complete_address' => 'address',
        ];
    }
    

    public function getSkillsAttribute($value)
    {
        return json_decode($value, true) ?? [];
    }

    
}
    