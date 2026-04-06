# Laravel Breeze Installation Guide

**Installation Date:** April 6, 2026  
**Project:** News Portal AI  
**Breeze Version:** v2.4.1  
**Stack:** Blade with Alpine.js

---

## Table of Contents

1. [Overview](#overview)
2. [What Was Installed](#what-was-installed)
3. [File Structure](#file-structure)
4. [Authentication Features](#authentication-features)
5. [Key Files Explained](#key-files-explained)
6. [Getting Started](#getting-started)
7. [Database Setup](#database-setup)
8. [Frontend Configuration](#frontend-configuration)
9. [Customization Guide](#customization-guide)
10. [Troubleshooting](#troubleshooting)

---

## Overview

**Laravel Breeze** is a lightweight authentication scaffolding for Laravel that provides a quick way to set up user authentication with pre-built views, controllers, and routes. The Blade with Alpine.js stack offers:

- **Server-rendered templates** using Blade
- **Lightweight interactivity** with Alpine.js
- **Tailwind CSS** for styling
- **Complete authentication system** (login, registration, password reset, email verification)
- **User profile management**
- **Testing framework** setup (Pest)

### Why Breeze?

- Faster development setup
- Production-ready authentication
- Security best practices included
- Minimal dependencies compared to other solutions
- Easy to customize and extend

---

## What Was Installed

### Composer Package
```
laravel/breeze: ^2.4.1
```

### Installation Command
```bash
php composer.phar require laravel/breeze --dev
php artisan breeze:install --stack=blade
```

### Options Selected
- **Stack:** Blade with Alpine (traditional server-rendered)
- **Dark Mode:** No
- **Testing Framework:** Pest

---

## File Structure

### New Directories Created

```
resources/
├── views/
│   ├── auth/                    # Authentication templates
│   │   ├── confirm-password.blade.php
│   │   ├── forgot-password.blade.php
│   │   ├── login.blade.php
│   │   ├── register.blade.php
│   │   ├── reset-password.blade.php
│   │   └── verify-email.blade.php
│   ├── components/              # Reusable Blade components
│   ├── layouts/                 # Layout templates
│   │   ├── app.blade.php       # Main authenticated layout
│   │   ├── guest.blade.php     # Guest/login layout
│   │   └── navigation.blade.php # Navigation component
│   ├── dashboard.blade.php      # User dashboard
│   └── profile/                 # Profile management views
│       ├── delete-user.blade.php
│       ├── edit.blade.php
│       └── partials/
│
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/                # Authentication controllers
│   │   │   ├── AuthenticatedSessionController.php      # Login
│   │   │   ├── ConfirmablePasswordController.php       # Password confirmation
│   │   │   ├── EmailVerificationNotificationController.php
│   │   │   ├── EmailVerificationPromptController.php
│   │   │   ├── NewPasswordController.php               # Password reset
│   │   │   ├── PasswordController.php                  # Change password
│   │   │   ├── PasswordResetLinkController.php
│   │   │   ├── RegisteredUserController.php            # Registration
│   │   │   └── VerifyEmailController.php
│   │   └── ProfileController.php # User profile management
│   └── Requests/                # Form request validation
│       └── (Breeze request classes)
│
database/
└── migrations/
    └── (Existing migrations remain unchanged)
```

---

## Authentication Features

### 1. **User Registration**
- New user account creation
- Email verification
- Password confirmation
- Validation rules

**Route:** `GET/POST /register`  
**Controller:** `RegisteredUserController`  
**View:** `resources/views/auth/register.blade.php`

### 2. **User Login**
- Email/password authentication
- Remember me functionality
- Session management

**Route:** `GET/POST /login`  
**Controller:** `AuthenticatedSessionController`  
**View:** `resources/views/auth/login.blade.php`

### 3. **Email Verification**
- Sends verification email after registration
- Resend verification link
- Blocks unverified user access to protected routes

**Routes:** `/verify-email`, `/email/verification-notification`  
**Controllers:** `EmailVerificationPromptController`, `EmailVerificationNotificationController`, `VerifyEmailController`

### 4. **Password Reset**
- Forgot password link
- Email-based password reset
- Token verification
- New password submission

**Routes:** `/forgot-password`, `/reset-password/{token}`  
**Controllers:** `PasswordResetLinkController`, `NewPasswordController`

### 5. **Password Confirmation**
- Requires password confirmation for sensitive operations
- Time-based confirmation window

**Route:** `/confirm-password`  
**Controller:** `ConfirmablePasswordController`

### 6. **User Profile**
- View user information
- Edit profile
- Change password
- Delete account

**Routes:** `/profile`, `/profile (PUT)`, `/profile (DELETE)`  
**Controller:** `ProfileController`

### 7. **Logout**
- Session termination
- CSRF protection

**Route:** `POST /logout`  
**Controller:** `AuthenticatedSessionController`

---

## Key Files Explained

### Routes Configuration

**File:** `routes/web.php`

The following routes have been registered:

```
GET  /                  → Welcome page (guest)
GET  /register          → Registration form
POST /register          → Handle registration
GET  /login             → Login form
POST /login             → Handle login
POST /logout            → Handle logout
GET  /forgot-password   → Password reset request
POST /forgot-password   → Send reset link
GET  /reset-password/:token → Reset form
POST /reset-password    → Handle password reset
GET  /verify-email      → Email verification prompt
POST /email/notification → Resend verification
GET  /email/verify/:id/:hash → Verify email
GET  /dashboard         → User dashboard (protected)
GET  /profile           → Profile view (protected)
PUT  /profile           → Update profile (protected)
DELETE /profile         → Delete account (protected)
```

### Middleware

**File:** `app/Http/Middleware/`

Breeze uses these key middleware:

- **`auth`** - Redirects unauthenticated users to login
- **`guest`** - Redirects authenticated users away from auth pages
- **`verified`** - Ensures user has verified their email

### User Model

**File:** `app/Models/User.php`

Modified to include:
- Email verification support
- Date timestamps
- Hidden password field
- Casts for JSON fields

### Validation Requests

**File:** `app/Http/Requests/`

Form validation classes for:
- Registration
- Login
- Password reset
- Profile updates

---

## Getting Started

### Step 1: Environment Configuration

**File:** `.env`

Ensure these are set correctly:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
```

### Step 2: Run Migrations

```bash
php artisan migrate
```

This creates:
- `users` table - User accounts and credentials
- `password_reset_tokens` table - Password reset tokens
- `sessions` table - Session data
- `cache` and `jobs` tables - Laravel system tables

### Step 3: Start Development Server

```bash
php artisan serve
```

Server runs at: `http://127.0.0.1:8000`

### Step 4: Access Application

- **Welcome page:** `http://127.0.0.1:8000`
- **Register:** `http://127.0.0.1:8000/register`
- **Login:** `http://127.0.0.1:8000/login`

---

## Database Setup

### Database Tables Created

#### 1. **users**
```sql
- id (Primary Key)
- name (string)
- email (unique string)
- email_verified_at (nullable timestamp)
- password (hashed string)
- remember_token (nullable)
- created_at, updated_at (timestamps)
```

#### 2. **password_reset_tokens**
```sql
- email (Primary Key)
- token (hashed string)
- created_at (timestamp)
```

#### 3. **sessions**
```sql
- id (Primary Key)
- user_id (nullable)
- ip_address (string)
- user_agent (text)
- payload (text)
- last_activity (integer timestamp)
```

### Database Seeding

To create test users, modify `database/seeders/DatabaseSeeder.php`:

```php
public function run(): void
{
    User::factory()
        ->count(10)
        ->create();
}
```

Then run:
```bash
php artisan db:seed
```

---

## Frontend Configuration

### CSS Framework: Tailwind CSS

Breeze includes Tailwind CSS for styling. Configuration:

**File:** `tailwind.config.js`

### JavaScript: Alpine.js

Alpine provides lightweight interactivity:
- Dropdown menus
- Modal dialogs
- Form interactions

**File:** `resources/js/app.js`

### Vite (Build Tool)

**File:** `vite.config.js`

Build frontend assets:

```bash
npm install          # Install dependencies
npm run build        # Production build
npm run dev          # Development watch
```

**Note:** Node.js and npm need to be installed if not already present.

---

## Customization Guide

### 1. **Customize Registration Form**

**File:** `resources/views/auth/register.blade.php`

Add custom fields:
```blade
<div class="mt-4">
    <x-input-label for="phone" :value="__('Phone')" />
    <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" />
</div>
```

Update validation in `app/Http/Requests/StoreUserRequest.php`:
```php
'phone' => 'required|string|max:20',
```

### 2. **Customize Login Form**

**File:** `resources/views/auth/login.blade.php`

Add OAuth buttons, two-factor authentication, etc.

### 3. **Modify User Model**

**File:** `app/Models/User.php`

Add custom fields:
```php
protected $fillable = [
    'name',
    'email',
    'password',
    'phone', // Add custom field
];

protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
];
```

### 4. **Extend Authentication Controllers**

Add custom logic in `app/Http/Controllers/Auth/`:
- Two-factor authentication
- Social authentication
- Custom email notifications
- Additional validation

### 5. **Customize Dashboard**

**File:** `resources/views/dashboard.blade.php`

Replace with your custom content after user login.

### 6. **Styled Components**

Breeze includes reusable Blade components:

```blade
<x-button>Click me</x-button>
<x-input-label for="email" :value="__('Email')" />
<x-text-input id="email" type="email" name="email" />
<x-input-error :messages="$errors->get('email')" class="mt-2" />
```

---

## Troubleshooting

### Issue: "Composer not found" error

**Solution:** Use the full path to PHP composer:
```bash
php composer.phar require [package]
```

Or install Composer globally for your system.

### Issue: Database connection error

**Solution:** Verify `.env` file:
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=news_portal_ai
DB_USERNAME=root
DB_PASSWORD=
```

Then run migrations:
```bash
php artisan migrate
```

### Issue: Email verification not sending

**Solution:** Configure mail in `.env`:
```env
MAIL_MAILER=log  # Development: logs emails
# Or use SMTP service like Mailtrap, SendGrid, etc.
```

Check `storage/logs/laravel.log` for errors.

### Issue: Session issues or login not persisting

**Solution:** Clear session and cache:
```bash
php artisan cache:clear
php artisan session:flush
php artisan config:clear
```

### Issue: "Blade component not found" error

**Solution:** Ensure Vite is running (for development):
```bash
npm run dev
```

Or rebuild production assets:
```bash
npm run build
```

### Issue: Password reset token expired

**Solution:** Check `.env` for token expiration:
```env
PASSWORD_RESET_TIMEOUT=60  # Minutes
```

---

## Security Features

### 1. **CSRF Protection**
All forms include CSRF tokens automatically via `@csrf`

### 2. **Password Hashing**
Passwords hashed using bcrypt (Laravel's default)

### 3. **Email Verification**
Unverified users cannot access protected routes

### 4. **Session Management**
- Secure session storage
- Configurable timeout
- Remember me functionality

### 5. **Rate Limiting**
Configure in `app/Http/Kernel.php`:
```php
'throttle' => 'rate_limit:60,1',
```

### 6. **Input Validation**
All user inputs validated using Form Request classes

---

## Next Steps

1. **Customize views** to match your design
2. **Add custom fields** to user model if needed
3. **Set up email service** for notifications
4. **Configure authentication guards** if using multiple user types
5. **Add authorization policies** for role-based access
6. **Set up testing** for authentication flows
7. **Deploy** to production server

---

## Useful Commands

```bash
# Clear application caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# View all routes
php artisan route:list

# Migrate database
php artisan migrate
php artisan migrate:rollback

# Create new migration
php artisan make:migration migration_name

# Run tests
php artisan test
./vendor/bin/pest

# Generate models with controllers
php artisan make:model ModelName -m -c

# Check cache status
php artisan tinker
```

---

## References

- [Laravel Breeze Documentation](https://laravel.com/docs/breeze)
- [Laravel Authentication](https://laravel.com/docs/authentication)
- [Blade Templating](https://laravel.com/docs/blade)
- [Alpine.js Documentation](https://alpinejs.dev/)
- [Tailwind CSS](https://tailwindcss.com/)

---

## Support

For issues or questions:
1. Check Laravel documentation
2. Review generated files and comments
3. Check `storage/logs/laravel.log` for errors
4. Run `php artisan tinker` for debugging

---

**Last Updated:** April 6, 2026  
**Status:** Installation Complete ✓
