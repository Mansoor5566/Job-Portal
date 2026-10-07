<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SeekerProfile extends Model
{
    protected $fillable = [
    'user_id', 'phone', 'location', 'bio',
    'resume', 'profile_photo', 'skills', 'experience_level'
];
protected $casts = ['skills' => 'array'];
}
