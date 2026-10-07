<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'job_listings';

    protected $fillable = [
        'user_id', 'category_id', 'title', 'slug', 'description',
        'location', 'is_remote', 'job_type', 'experience_level',
        'salary_min', 'salary_max', 'skills_required',
        'deadline', 'status', 'is_featured'
    ];

    protected $casts = [
        'skills_required' => 'array',
        'is_remote'       => 'boolean',
        'deadline' => 'date',
    ];

    public function employer()     { return $this->belongsTo(User::class, 'user_id'); }
    public function category()     { return $this->belongsTo(Category::class); }
    public function applications() { return $this->hasMany(Application::class); }
    public function savedByUsers() { return $this->hasMany(SavedJob::class); }
}