# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Commands

```bash
# Initial setup
composer setup          # Install deps, copy .env, generate key, run migrations, build assets

# Development
composer dev            # Runs PHP server + queue worker + log viewer + Vite concurrently

# Individual processes
php artisan serve       # Laravel dev server
npm run dev             # Vite HMR dev server
php artisan queue:listen # Queue worker

# Testing
composer test           # PHPUnit test suite
php artisan test --filter=TestName  # Single test

# Code style
php artisan pint        # Fix PHP code style (Laravel Pint)

# Production build
npm run build
```

## Architecture

**Stack:** Laravel 12 + Blade + Alpine.js + Tailwind CSS + Vite. SQLite by default.

**What it is:** A church management system (SDA) for tracking members, departments, finances (tithes/offerings/donations/expenditures/funds), baptisms, transfers, announcements, and documents.

### Auth & Roles

Laravel Breeze handles authentication. Role-based access is enforced via middleware on controller constructors:
- `RestrictMemberAccess` — blocks members from admin functions
- `RestrictTreasurerAccess` — limits treasurer scope
- `RestrictFundsControllerAccess` — limits funds controller role

Roles: Super Admin, Pastor, Clerk, Treasurer, Head Elder, Department Leader, Funds Controller, Member.

Forced password change middleware (`ForcePasswordChange`) redirects on first login.

### Models & Relationships

Primary key on `Member` is `member_id` (not `id`). Key relationships:
- `Member` → hasMany Tithe, Donation, Baptism, Transfer; hasOne User; belongsToMany Department
- `Department` → belongsToMany Member (via pivot)
- Financial models (Tithe, Offering, Donation, ClassFund, DepartmentFund) → belongsTo Member

### Controllers

Standard RESTful resource controllers. Common patterns:
- Search with `request('search')` + `->paginate(15)`
- `ExportService` injected for CSV/PDF/ZIP exports
- Role middleware applied in constructor

### Export System

`app/Services/ExportService.php` handles three formats:
- **CSV**: UTF-8 BOM streamed response (Excel compatible)
- **PDF**: DomPDF with dedicated Blade views under `resources/views/exports/`
- **ZIP**: Bundles multiple files for batch download

### Frontend

- **Alpine.js** for interactivity (modals, toggles) — keep JS minimal and declarative
- **Tailwind CSS** with `@tailwindcss/forms` plugin; font is Figtree
- Blade components: `x-app-layout`, `x-export-dropdown`
- Form validation errors rendered server-side with `$errors` bag

### Key Routes

- `GET /create-admin` — first-run admin creation (no auth required)
- `GET /dashboard` — role-aware main dashboard
- Resource routes for members, departments, baptisms, transfers, announcements, documents
- Export routes accept `?format=csv|pdf`
