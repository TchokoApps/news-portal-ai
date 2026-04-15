---
name: laravel-news-portal-ai-module-guide
description: Expert workflow for implementing modules (CRUD, Auth, Localization) in the Laravel News Portal AI project using Stisla Admin Template.
applyTo: ["**/*.php", "**/*.blade.php", "routes/web.php", "routes/admin.php"]
---

# Laravel News Portal AI Development Guide

This skill encapsulates the project-specific patterns and standards for building modules in the News Portal AI application.

## 🏗 Project Architecture & Tech Stack
- **Framework:** Laravel 11.x
- **Admin Template:** Stisla (included in `public/admin/assets`)
- **Main Layout:** `admin.layouts.master`
- **Auth Guards:** `web` (Users), `admin` (Admins)
- **Database:** SQLite (default for development)
- **Frontend Stack:** Blade, jQuery, Bootstrap 4 (Stisla), SweetAlert2, DataTables, Select2.

---

## 🚀 Module Implementation Pattern (The "Standard Flow")

When the user asks to "Create a [Module]", follow these sequential steps:

### 1. Database & Model
- Create Model + Migration: `php artisan make:model [Name] -m`
- **Migration Standards:**
  - Use `text('image')` for file paths.
  - Use `boolean('status')->default(1)` for toggles.
  - Ensure foreign keys use `constrained()->cascadeOnDelete()`.
- **Model Standards:**
  - Add `$fillable` fields.
  - Set up relationships (e.g., `belongsTo`, `hasMany`).

### 2. Controller & Request
- Create a Resource Controller: `php artisan make:controller Admin/[Name]Controller --resource`
- Create Form Request for validation: `php artisan make:request Admin/[Name]StoreRequest`
- **Controller Logic:**
  - Use `try-catch` blocks for database operations.
  - Return `toastr` notifications or similar SweetAlert2 responses.
  - Handle image uploads using `File` or `Storage` facades.

### 3. Routing
- Register routes in `routes/admin.php` within the appropriate middleware group.
- Always use **Named Routes** (e.g., `admin.category.index`).

### 4. Views (The Stisla Pattern)
- **Location:** `resources/views/admin/[module]/`
- **Template Extension:** `@extends('admin.layouts.master')`
- **Content Section:** `@section('content')`
- **DataTables Implementation:**
  ```html
  <table class="table table-striped" id="table-1">
      <!-- ... -->
  </table>
  ```
  Push scripts to the `@stack('scripts')` stack.

---

## 🎨 UI/UX Guidelines (Mandatory)

### Icons
- Use **FontAwesome 5** (e.g., `<i class="fas fa-plus"></i>`).
- **User Request Exception:** If asked to "remove left/right icons" in sidebar, use `display: none !important;` in a `<style>` block in `sidebar.blade.php`.

### Notifications & Feedback
- Use **SweetAlert2** for delete confirmations.
- Ensure all forms have error validation blocks:
  ```html
  @error('field')
      <span class="text-danger">{{ $message }}</span>
  @enderror
  ```

---

## 🔧 Maintenance Commands
- **Migrations:** `php artisan migrate`
- **Cache Clear:** `php artisan optimize:clear`
- **Vite (if used):** `npm run dev`

## 📝 Change Logging
- After every major feature, update or create a log file in the root (e.g., `0XX_FEATURE_NAME_LOG.md`) summarizing:
  - Task description
  - Files created/modified
  - Database changes
  - Verification steps
