<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployerProfile extends Model
{
    protected $fillable = [
    'user_id', 'company_name', 'company_logo',
    'company_description', 'website', 'industry',
    'company_size', 'location'
];
}
