# Secure-Web-Simple
Secure Software Development Project
🔐 Secure Booking Management System

Secure Software Development Project – Laravel

📌 Project Overview

This project is a Secure Booking Management System developed using Laravel and follows Secure Software Development principles.
The system allows authenticated users to create and manage bookings securely, while administrators can monitor and manage all bookings through a protected admin panel.

Security controls are implemented based on OWASP Top 10 recommendations.

🎯 Project Objectives

Implement secure authentication and authorization

Prevent unauthorized access to resources

Apply secure input validation and data handling

Protect sessions and forms using CSRF

Maintain accountability through audit logging

Demonstrate secure CRUD implementation

🛠️ Technology Stack

Framework: Laravel (with Breeze)

Language: PHP

Database: SQLite

Frontend: Blade + Tailwind CSS

Authentication: Laravel Breeze

Session Storage: Database-based sessions

Version Control: Git & GitHub

👤 User Roles
Role	Permissions
User	Create, view, edit, and delete own bookings only
Admin	View and delete all bookings
🔐 Security Features Implemented
1️⃣ Authentication & Authorization

Secure login & registration using Laravel Breeze

Passwords hashed using Bcrypt

Route protection using auth middleware

Role-based access control (admin, user)

Route::middleware('auth')->group(function () {
    Route::resource('bookings', BookingController::class);
});

2️⃣ Secure CRUD (Booking System)

Users can only manage their own bookings

Admin can manage all bookings

Ownership validation enforced server-side

if ($booking->user_id !== Auth::id()) {
    abort(403);
}

3️⃣ Input Validation

All user inputs are validated and sanitized before processing.

$request->validate([
    'service_name' => 'required|in:Consultation,System Maintenance,Technical Support,Security Audit',
    'booking_date' => 'required|date',
    'booking_time' => 'required',
]);


✔ Prevents injection
✔ Enforces strict whitelisting

4️⃣ Session & CSRF Protection

CSRF tokens enabled on all forms

HttpOnly session cookies

Database-backed session storage

@csrf

SESSION_DRIVER=database
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax

5️⃣ Audit Logging (Accountability)

All sensitive actions are logged:

Booking creation

Booking updates

Booking deletion

AuditLog::create([
    'user_id'   => Auth::id(),
    'action'    => 'CREATE',
    'entity'    => 'booking',
    'entity_id' => $booking->id,
]);


This ensures non-repudiation and traceability.

6️⃣ Admin Panel Security

Admin-only routes protected by role checks

Unauthorized access returns HTTP 403 Forbidden

if (!Auth::user()->isAdmin()) {
    abort(403);
}

🧩 Database Structure
Users Table

id

name

email

password

role

Bookings Table

id

service_name

booking_date

booking_time

user_id

Audit Logs Table

id

user_id

action

entity

entity_id

created_at

🚀 Installation & Setup
1️⃣ Clone Repository
git clone https://github.com/your-username/secure-booking-system.git
cd secure-booking-system

2️⃣ Install Dependencies
composer install
npm install
npm run build

3️⃣ Environment Setup
cp .env.example .env
php artisan key:generate

4️⃣ Database & Migration
php artisan migrate
php artisan db:seed

5️⃣ Run Application
php artisan serve


Or via Laravel Herd:

http://secure-task-manager.test

🧪 Testing

Manual functional testing

Authentication & access control tested

Unauthorized access returns HTTP 403

CSRF protection verified

🛡️ OWASP Top 10 Mapping
OWASP Risk	Mitigation
Broken Access Control	Role checks & ownership validation
Injection	Strict input validation
Security Misconfiguration	.env configuration
CSRF	CSRF tokens
Identification & Auth Failures	Laravel Breeze
📄 License

This project is for academic and learning purposes only.

✍️ Author

Name: MUHAMMAD ALIFF
Course: Secure Software Development
Institution: UniKL MIIT

⭐ Notes for Evaluation

This project demonstrates:

Secure coding practices

Defense-in-depth approach

Practical implementation of OWASP principles

Proper documentation and traceability
