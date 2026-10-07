<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
     $categories = [
    'Information Technology', 'Design & Creative', 'Marketing',
    'Finance & Accounting', 'Healthcare', 'Education',
    'Engineering', 'Sales', 'Customer Support', 'Human Resources'
];
foreach ($categories as $cat) {
    Category::create([
        'name' => $cat,
        'slug' => Str::slug($cat)
    ]);
}
    }
}
