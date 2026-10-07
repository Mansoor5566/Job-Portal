<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean', // ← this was missing
        ];
    }

    // Relationships
    public function employerProfile() { return $this->hasOne(EmployerProfile::class); }
    public function seekerProfile()   { return $this->hasOne(SeekerProfile::class); }
    public function jobs()            { return $this->hasMany(Job::class); }
    public function applications()    { return $this->hasMany(Application::class); }
    public function savedJobs()       { return $this->hasMany(SavedJob::class); }

    // Role helpers
    public function isAdmin()    { return $this->role === 'admin'; }
    public function isEmployer() { return $this->role === 'employer'; }
    public function isSeeker()   { return $this->role === 'seeker'; }
}