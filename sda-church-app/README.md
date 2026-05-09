# SDA Church Management System (SDA-CMS)

A web-based church management system for Seventh-day Adventist congregations. Manages members, departments, finances (tithes, offerings, donations, expenditures), baptisms, transfers, announcements, and documents — with role-based access control.

---

## Requirements

Before you begin, make sure the following are installed on your machine:

| Tool | Minimum Version | Check with |
|------|----------------|------------|
| PHP | 8.2+ | `php -v` |
| Composer | 2.x | `composer -V` |
| Node.js | 18+ | `node -v` |
| npm | 9+ | `npm -v` |
| SQLite | (bundled with PHP) | `php -m \| grep sqlite` |

> **Windows users:** PHP needs to have the `pdo_sqlite` and `fileinfo` extensions enabled in your `php.ini`.

---

## Installation

### 1. Clone the repository

```bash
git clone <your-repo-url> SDA-CMS
cd SDA-CMS
```

### 2. Navigate into the app directory

> **Important:** All commands from this point on must be run from inside the `sda-church-app` folder.

```bash
cd sda-church-app
```

---

### 3. Install PHP dependencies

```bash
composer install
```

---

### 4. Set up the environment file

```bash
cp .env.example .env
```

Then open `.env` and update the `APP_NAME`:

```env
APP_NAME="SDA Church"
```

---

### 5. Generate the application key

```bash
php artisan key:generate
```

---

### 6. Create the SQLite database file

```bash
# Linux / macOS
touch database/database.sqlite

# Windows (PowerShell)
New-Item -ItemType File database\database.sqlite
```

---

### 7. Run database migrations

```bash
php artisan migrate
```

---

### 8. Install frontend dependencies and build assets

```bash
npm install
npm run build
```

---

### 9. Create the storage symlink

This links `public/storage` to `storage/app/public` so uploaded files (documents, profile pictures) are publicly accessible.

```bash
php artisan storage:link
```

---

### 10. Create the storage folders

These folders hold uploaded files. Create them so file uploads work immediately:

```bash
# Linux / macOS
mkdir -p storage/app/public/documents
mkdir -p storage/app/public/profile_pictures

# Windows (PowerShell)
New-Item -ItemType Directory -Force -Path storage\app\public\documents
New-Item -ItemType Directory -Force -Path storage\app\public\profile_pictures
```

| Folder | Purpose |
|--------|---------|
| `storage/app/public/documents` | Church documents uploaded via the Documents module |
| `storage/app/public/profile_pictures` | Member profile photos |

---

### 11. Start the development server

```bash
php artisan serve
```

The app will be available at **http://localhost:8000**.

---

## First-Time Setup: Create the Admin Account

On a fresh install there are no user accounts. Visit the admin creation page to set up your first Super Admin:

```
http://localhost:8000/create-admin
```

Fill in the form and submit. Once the admin account is created, **do not share this URL** — it requires no authentication. You can disable it later by removing or commenting out the two `/create-admin` routes in `routes/web.php`.

---

## Running the Full Dev Environment

To run the PHP server, queue worker, log viewer, and Vite hot-reload all at once:

```bash
composer dev
```

Or run each process separately in different terminals:

```bash
# Terminal 1 — Laravel server
php artisan serve

# Terminal 2 — Vite (hot module replacement)
npm run dev

# Terminal 3 — Queue worker (for background jobs / emails)
php artisan queue:listen
```

---

## User Roles

| Role | Access Level |
|------|-------------|
| Super Admin | Full access to everything |
| Pastor | Full access except finance management |
| Clerk | Members, baptisms, transfers, documents, announcements |
| Treasurer | Finance module only |
| Head Elder | Dashboard + member read access |
| Department Leader | Their department and members |
| Funds Controller | Class and department funds only |
| Member | Personal dashboard and announcements |

New members are given the default password `SDA-1234` and are prompted to change it on first login.

---

## Optional Configuration

### Using MySQL instead of SQLite

Update your `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sda_cms
DB_USERNAME=root
DB_PASSWORD=your_password
```

Create the database in MySQL first, then run `php artisan migrate`.

### Email (for password resets)

The default mailer writes emails to the log file (`storage/logs/laravel.log`). To send real emails, update `.env` with your SMTP credentials:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS="noreply@yourchurch.org"
MAIL_FROM_NAME="SDA Church"
```

---

## Running Tests

```bash
composer test
```

---

## Project Structure (key paths)

```
sda-church-app/
├── app/
│   ├── Http/Controllers/   # All controllers
│   ├── Models/             # Eloquent models
│   └── Services/           # ExportService (CSV, PDF, ZIP)
├── database/
│   ├── migrations/         # Database schema
│   └── database.sqlite     # SQLite database (created in step 6)
├── public/
│   └── storage/            # Symlink to storage/app/public (step 9)
├── resources/views/        # Blade templates
├── routes/web.php          # All application routes
└── storage/app/public/
    ├── documents/          # Uploaded church documents
    └── profile_pictures/   # Member profile photos
```

---

## Troubleshooting

**"No application encryption key has been specified"**
Run `php artisan key:generate`.

**"Database file not found" / SQLite errors**
Make sure `database/database.sqlite` exists (step 6).

**Uploaded files not displaying / 404 on images**
Run `php artisan storage:link` (step 9) and confirm the `public/storage` symlink exists.

**Assets not loading (CSS/JS 404)**
Run `npm run build` or `npm run dev` to compile assets.

**"php_fileinfo" extension missing (Windows)**
Open your `php.ini`, find `;extension=fileinfo`, and remove the leading semicolon. Restart your server.
