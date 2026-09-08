# Depiderme

Marketing website and lightweight CMS for **Depiderme** — a Portuguese network of medical-aesthetic laser hair removal clinics. The public site presents clinic information, technology, pricing, and booking; the admin panel lets non-technical staff edit page content, manage media, and review booking requests.

Built with **Laravel 13**, **Blade**, **Tailwind CSS 4**, and **Vite 8**.

---

## Table of contents

- [Features](#features)
- [Tech stack](#tech-stack)
- [Requirements](#requirements)
- [Quick start](#quick-start)
- [Environment configuration](#environment-configuration)
- [Database setup](#database-setup)
- [Running the application](#running-the-application)
- [Accounts & credentials](#accounts--credentials)
- [Public pages](#public-pages)
- [Admin panel](#admin-panel)
- [CMS architecture](#cms-architecture)
- [Content field types](#content-field-types)
- [Blade helpers](#blade-helpers)
- [Frontend assets](#frontend-assets)
- [Booking form](#booking-form)
- [Project structure](#project-structure)
- [Development commands](#development-commands)
- [Deployment notes](#deployment-notes)
- [License](#license)

---

## Features

### Public website

- Responsive, design-driven marketing pages (home, about, technology, pricing, clinics, Laserderme product, contact)
- Scroll-driven section animations (rise overlays, leader headline reveal)
- Interactive UI: mobile menu, carousels, FAQ accordion, pricing gender toggle, clinics accordion & gallery
- Animated laser beam divider on the homepage experience section
- Hero background video on the homepage
- Booking form with server-side validation and rate limiting

### Admin CMS

- Secure login for admin users only
- Visual content editor (no raw JSON) with accordions, repeaters, lists, and image pickers
- Per-page content management driven by PHP config schemas
- Media uploads integrated in the CMS image picker (no separate library page)
- Booking submission inbox with read/unread status
- Non-editable fields hidden from admins (navigation links, layout metadata, alt text, etc.)
- Content cached in memory for fast front-end reads

---

## Tech stack

| Layer | Technology |
|-------|------------|
| Backend | PHP 8.3+, Laravel 13 |
| Database | MySQL / MariaDB / SQLite |
| Templates | Blade |
| Styling | Tailwind CSS 4 |
| Build tool | Vite 8 |
| Fonts | Instrument Sans (via Laravel Vite fonts) |
| Auth | Laravel session auth + custom `admin` middleware |

---

## Requirements

- PHP **8.3** or higher with extensions: `mbstring`, `openssl`, `pdo`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`
- Composer 2.x
- Node.js **18+** and npm
- MySQL 8+ / MariaDB 10+ (recommended) or SQLite (local dev)

---

## Quick start

```bash
# Clone the repository and enter the project directory
cd depiderme-project

# Install PHP dependencies
composer install

# Copy environment file and generate app key
cp .env.example .env
php artisan key:generate

# Configure your database in .env (see below), then run migrations and seeders
php artisan migrate --seed

# Link public storage for uploaded media
php artisan storage:link

# Install and build front-end assets
npm install
npm run build

# Start the development server
php artisan serve
```

Visit `http://127.0.0.1:8000`.

Alternatively, use the Composer setup script (runs install, migrate, and build in one go):

```bash
composer setup
```

---

## Environment configuration

Copy `.env.example` to `.env` and adjust the following variables.

### Application

```env
APP_NAME=Depiderme
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000
```

### MySQL (recommended — e.g. MAMP)

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=8889
DB_DATABASE=depiderme
DB_USERNAME=root
DB_PASSWORD=root
```

> **MAMP note:** MySQL typically runs on port `8889`. Point your web server document root to `public/`, e.g. `http://127.0.0.1:8888/depiderme-project/public/`.

### SQLite (simple local dev)

```env
DB_CONNECTION=sqlite
# DB_DATABASE is not needed; Laravel uses database/database.sqlite
```

Create the file if it does not exist:

```bash
touch database/database.sqlite
```

### Session & cache

The default `.env.example` uses database sessions and cache, which requires the migrations to be run.

---

## Database setup

```bash
# Fresh install with seed data
php artisan migrate --seed

# Reset everything and re-seed (destructive)
php artisan migrate:fresh --seed
```

Seeders create:

1. **Admin user** — see [Accounts & credentials](#accounts--credentials)
2. **CMS content** — all default values from `config/cms/pages/*.php` synced into `content_entries`

---

## Running the application

### Laravel built-in server

```bash
php artisan serve
```

### Full dev stack (server + queue + logs + Vite HMR)

```bash
composer dev
```

### Vite only (hot reload for CSS/JS)

```bash
npm run dev
```

### Production asset build

```bash
npm run build
```

Run `npm run build` after any change to files in `resources/css/` or `resources/js/`.

---

## Accounts & credentials

Default values used after `php artisan migrate --seed`. **Change all passwords before deploying to production.**

### Local URLs

| Environment | Public site | Admin login |
|-------------|-------------|-------------|
| `php artisan serve` | `http://127.0.0.1:8000` | `http://127.0.0.1:8000/login` |
| MAMP (example) | `http://127.0.0.1:8888/depiderme-project/public/` | `http://127.0.0.1:8888/depiderme-project/public/login` |

Admin panel (after login): append `/admin` to the base URL.

---

### Admin account

Created by `AdminUserSeeder`:

| Field | Value |
|-------|-------|
| Name | `Administrador` |
| Email | `admin@depiderme.pt` |
| Password | `password` |
| Role | Admin (`is_admin = true`) |
| Login page | `/login` |
| Dashboard | `/admin` |

---

### Database (MySQL — MAMP)

Example `.env` values for local development with MAMP:

| Variable | Value |
|----------|-------|
| `DB_CONNECTION` | `mysql` |
| `DB_HOST` | `127.0.0.1` |
| `DB_PORT` | `8889` |
| `DB_DATABASE` | `depiderme` |
| `DB_USERNAME` | `root` |
| `DB_PASSWORD` | `root` |

Create the database in phpMyAdmin (or MAMP) before running migrations:

```sql
CREATE DATABASE depiderme CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

---

### Default site contact (CMS)

These are seeded into the CMS (`global` page) and shown on the public site. They are **not** login credentials — edit them in **Admin → Content → Global**.

| Field | Default value |
|-------|---------------|
| Site email | `info@depiderme.pt` |
| Site phone | `+351 244 000 000` |

---

### Mail (local development)

By default, outgoing mail is written to the log (no real emails sent):

```env
MAIL_MAILER=log
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"
```

Configure SMTP in `.env` for production if you need email notifications.

---

## Public pages

| Route | View | Description |
|-------|------|-------------|
| `/` | `home` | Homepage — hero video, leader, experience, clinics teaser, packs, booking, end image |
| `/about` | `about` | About the clinic network |
| `/technology` | `technology` | Laser technology & equipment |
| `/pricing` | `pricing` | Pricing tables with gender toggle |
| `/clinics` | `clinics` | Clinic locations with accordion & galleries |
| `/laserderme` | `laserderme` | Laserderme product landing page |
| `/contact` | `contact` | Contact page with booking form |
| `POST /booking` | — | Booking form submission (throttled: 10/min) |

---

## Admin panel

| Route | Description |
|-------|-------------|
| `/login` | Admin login |
| `/admin` | Dashboard |
| `/admin/content` | List of editable CMS pages |
| `/admin/content/{page}` | Edit a specific page (e.g. `home`, `global`) |
| `/admin/submissions` | Booking form submissions |
| `/admin/submissions/{id}` | Submission detail |

All `/admin/*` routes require authentication and the `admin` middleware (`is_admin = true` on the user).

---

## CMS architecture

Content is defined in **PHP config schemas** and stored in the **database**. The config is the source of truth for field structure and defaults; the database holds the live values edited through the admin.

```
config/cms/pages/*.php   →  field definitions (type, label, default, section)
        ↓
ContentSeeder / syncFromConfig()
        ↓
content_entries table  →  live values
        ↓
ContentService (cached) →  content() / content_asset() in Blade views
```

### CMS pages

| Slug | Label | Public URL |
|------|-------|------------|
| `global` | Global | — (navbar, footer, shared labels) |
| `home` | Homepage | `/` |
| `about` | About | `/about` |
| `technology` | Technology | `/technology` |
| `pricing` | Pricing | `/pricing` |
| `clinics` | Clinics | `/clinics` |
| `laserderme` | Laserderme | `/laserderme` |
| `contact` | Contact | `/contact` |

### Static structured data

Some data that is not edited through the CMS lives in:

- `config/cms/data/clinics.php` — full clinic details for the clinics page
- `config/cms/data/pricing.php` — pricing category data

### Adding a new editable field

1. Add the field to the appropriate file in `config/cms/pages/`.
2. Run `php artisan db:seed --class=ContentSeeder` or `migrate:fresh --seed` to sync defaults.
3. Use `content('page', 'key')` or `content_asset('page', 'key')` in the Blade view.

### Hiding fields from admins

Set `'editable' => false` on any field in the config. These fields keep their default values and are filtered out in `ContentController`.

---

## Content field types

| Type | Admin UI | Storage |
|------|----------|---------|
| `text` | Single-line input | Plain string |
| `textarea` | Multi-line input | Plain string |
| `image` | Image picker with preview | Path (`images/...` or `storage/...`) |
| `list` | Add/remove text rows | JSON array |
| `links` | Label + URL pairs | JSON object `{ "Label": "/path" }` |
| `repeater` | Nested field groups | JSON array of objects |
| `pack_rows` | Promotional pack marquee rows | JSON (text + image cells) |
| `pricing` | Gender pricing tables | JSON |
| `json` | Raw JSON (rare) | JSON string |

Field partials live in `resources/views/admin/content/fields/`. Encoding/decoding is handled by `App\Services\CmsFieldService`.

---

## Blade helpers

Defined in `app/helpers.php`:

| Helper | Purpose |
|--------|---------|
| `content($page, $key, $default = null)` | Get a CMS text/JSON value |
| `content_asset($page, $key, $default = null)` | Get a resolved image URL |
| `cms_url($path)` | Build a URL from a CMS path or external link |
| `cms_field_editable($field)` | Check if a field is editable in admin |
| `admin_asset_url($path)` | Resolve an image path for the admin UI |
| `nl_to_br($text)` | Safe newline-to-`<br>` for headings |

Example in a Blade component:

```blade
<h1>{{ content('home', 'hero.title') }}</h1>
<img src="{{ content_asset('home', 'hero.image', 'images/hero.png') }}" alt="">
```

---

## Frontend assets

### Entry points (Vite)

| File | Used by |
|------|---------|
| `resources/css/app.css` | Public site |
| `resources/js/app.js` | Public site |
| `resources/css/admin.css` | Admin panel |
| `resources/js/admin-cms.js` | Admin CMS editor |

### JavaScript modules

| Module | Responsibility |
|--------|----------------|
| `scroll.js` | Section rise animations, leader headline reveal, navbar scroll state |
| `widgets.js` | Mobile menu, carousels, FAQ accordion, pricing toggle |
| `clinics.js` | Clinics page accordion & gallery (lazy-loaded) |
| `laserderme.js` | Word rotator & CTA effects (lazy-loaded) |
| `admin-cms.js` | Accordions, repeaters, image picker modal |

### Static assets

| Path | Contents |
|------|----------|
| `public/images/` | Site images, icons, logos |
| `public/videos/` | Hero background video (`hero-bg.mp4`) |
| `public/build/` | Compiled CSS/JS (generated by Vite) |
| `storage/app/public/media/` | Admin-uploaded images |

### Section rise animation

Sections with `data-section-rise` slide up over the previous section on scroll using `transform: translateY()`. The booking section and footer on the homepage also use this attribute.

---

## Booking form

- Submitted via `POST /booking` (route name: `booking.store`)
- Rate limited to **10 requests per minute** per IP
- Stores records in `form_submissions` with metadata (source page, IP, user agent)
- Admins review submissions at `/admin/submissions`
- Statuses: `new`, `read`, `archived`

---

## Project structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # Dashboard, content, media, submissions
│   │   ├── Auth/           # Login / logout
│   │   └── BookingController.php
│   └── Middleware/
│       └── EnsureUserIsAdmin.php
├── Models/
│   ├── ContentEntry.php
│   ├── FormSubmission.php
│   ├── Media.php
│   └── User.php
├── Services/
│   ├── ContentService.php  # Read/cache/sync CMS content
│   └── CmsFieldService.php # Encode/decode admin form values
└── helpers.php

config/
└── cms/
    ├── pages/              # Per-page field schemas
    └── data/               # Static structured data (clinics, pricing)

database/
├── migrations/
└── seeders/
    ├── AdminUserSeeder.php
    └── ContentSeeder.php

resources/
├── css/
│   ├── app.css             # Public site styles
│   └── admin.css           # Admin panel styles
├── js/
│   ├── app.js
│   ├── admin-cms.js
│   ├── scroll.js
│   └── widgets.js
└── views/
    ├── components/         # Reusable Blade components
    ├── admin/              # Admin panel views
    ├── auth/               # Login view
    └── layouts/            # app.blade.php, admin.blade.php

public/                     # Web root (point your server here)
routes/web.php              # All application routes
```

---

## Development commands

```bash
# Run tests
composer test
# or
php artisan test

# Clear CMS content cache
php artisan cache:clear

# Re-sync CMS defaults from config into the database
php artisan db:seed --class=ContentSeeder

# Code style (Laravel Pint)
./vendor/bin/pint

# Create storage symlink (required for uploaded media)
php artisan storage:link
```

---

## Deployment notes

1. Set `APP_ENV=production`, `APP_DEBUG=false`, and a strong `APP_KEY`.
2. Configure a production database (`DB_*` variables).
3. Run `composer install --no-dev --optimize-autoloader`.
4. Run `php artisan migrate --force` and seed if needed.
5. Run `php artisan storage:link`.
6. Run `npm ci && npm run build`.
7. Point the web server document root to `public/`.
8. Ensure `storage/` and `bootstrap/cache/` are writable.
9. Change the default admin password.
10. Set up a queue worker if using queued jobs (`php artisan queue:work`).

### Apache / MAMP

Enable `mod_rewrite`. The included `public/.htaccess` routes all requests through `public/index.php`.

### Caching in production

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

CMS content is cached separately via `ContentService` (`cms.content.all` key). It is cleared automatically when content is updated through the admin.

---

## License

This project is based on the [Laravel framework](https://laravel.com), which is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
