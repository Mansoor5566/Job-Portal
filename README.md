# JobPortal — Laravel Job Portal

A fully functional job portal built with Laravel 11, Blade, and Tailwind CSS.

## Features
- Multi-role auth (Seeker, Employer, Admin)
- Job listings with search & filters
- Job applications with resume upload
- Employer analytics dashboard
- Admin panel with full management
- Professional responsive design

## Tech Stack
- Laravel 11
- Blade Templates
- Tailwind CSS
- MySQL
- Chart.js

## Installation

1. Clone the repo
\```bash
git clone https://github.com/Mansoor5566/job-portal.git
cd job-portal
\```

2. Install dependencies
\```bash
composer install
npm install
\```

3. Setup environment
\```bash
cp .env.example .env
php artisan key:generate
\```

4. Configure database in `.env`
\```
DB_DATABASE=job_db
DB_USERNAME=root
DB_PASSWORD=
\```

5. Run migrations and seeders
\```bash
php artisan migrate
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=AdminSeeder
php artisan storage:link
\```

6. Run the app
\```bash
npm run dev
php artisan serve
\```

## Default Admin
- Email: admin@jobportal.com
- Password: admin123
