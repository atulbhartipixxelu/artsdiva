# ArtsDiva — Technical Architecture (Developer Handoff)

**Audience:** Developers who may maintain or extend the system later.  
**Stack:** Laravel 13 / PHP 8.3 / Blade / MySQL (or configured DB) / Vite + Tailwind (tooling) + `public/css/artsdiva.css`

---

## 1. What the system is

ArtsDiva is a Laravel web application with:

1. **Public frontend** — catalogue, artists, exhibitions, events, news, publications, leasing inquiry, static/CMS pages  
2. **Customer account area** — login/register, wishlist, orders (acquisition / lease)  
3. **Admin CMS** — `/admin` for content managers (artworks, artists, hero, content, inquiries, users)

Live staging historically: `https://pixxelu.com/dev/artsdiva` (subdirectory deploy on Hostinger).

---

## 2. High-level architecture

```
Browser
  │
  ├─ Public pages (Blade + artsdiva.css)
  ├─ Account area (auth + customer middleware)
  └─ Admin CMS (auth + admin / superadmin middleware)
        │
        ▼
   routes/web.php
        │
        ▼
   Controllers (Public / Account / Admin / Auth)
        │
        ├─ Models (Eloquent) ──► Database
        ├─ Support (ArtworkRepository, MediaUploader)
        └─ Services (CurrencyService, LeaseRateService)
```

---

## 3. Key folders

| Path | Role |
|------|------|
| `app/Http/Controllers/` | Public controllers |
| `app/Http/Controllers/Admin/` | CMS CRUD + status toggle |
| `app/Http/Controllers/Account/` | Customer dashboard / wishlist / orders |
| `app/Http/Middleware/` | `EnsureAdmin`, `EnsureSuperAdmin`, `EnsureCustomer` |
| `app/Models/` | Artwork, Artist, HeroSlide, Exhibition, Event, NewsPost, Publication, Page, Inquiry, User, Order, etc. |
| `app/Support/` | `MediaUploader`, `ArtworkRepository` |
| `app/Services/` | Currency + lease rate logic |
| `app/helpers.php` | `site_url()`, `site_page_url()`, `ad_img()` |
| `routes/web.php` | All HTTP routes |
| `resources/views/` | Public + admin Blade templates |
| `public/css/` | `artsdiva.css`, `admin.css` |
| `public/images/` | Static / catalogue images |
| `storage/app/public/` | Uploaded media (via `storage:link`) |
| `docs/` | Data-entry + architecture + master list exports |
| `scripts/` | One-off upsert / export utilities |

---

## 4. Data model (core)

### Artwork ↔ Artist
- `Artwork belongsTo Artist`
- `Artist hasMany Artwork`
- Artwork fields include: `serial_number` (unique inventory id), `title`, `slug`, `price_eur`, `description`, `thumbnail`, `gallery` (JSON array), `is_published`, `is_featured`, `sort_order`

### Other CMS entities
- `HeroSlide`, `Exhibition`, `Event`, `NewsPost`, `Publication`, `Page` — each with `is_published` (and usually image + text fields)
- `Inquiry` — leasing form submissions (admin read/manage)
- `User` — roles: `superadmin`, `admin`, `customer`; admins also use `is_active`

Schema origin: `database/migrations/2026_08_12_140000_create_artsdiva_cms_tables.php`  
Serial numbers: `database/migrations/2026_08_18_140000_add_serial_number_to_artworks_table.php`

---

## 5. Routes overview

### Public
- `/` home  
- `/catalogue`, `/catalogue/{slug}`, `/catalogue/suggest`  
- `/artists`, `/exhibitions`, `/events`, `/news`, `/publications` (+ detail where applicable)  
- `/about`, `/leasing`, `/services`, `/contact`  
- `/leasing-inquiry` GET/POST  

### Account (`/account/...`)
- Guest: login/register  
- Auth + `customer`: dashboard, wishlist, orders, profile  

### Admin (`/admin/...`)
- Guest: `/admin/login`  
- Auth + `admin`: dashboard, artworks, artists, hero, exhibitions, events, news, publications, pages, inquiries, status toggle  
- Auth + `superadmin`: users (Admins)  

Status toggle: `PATCH admin/{type}/{id}/toggle-status` → `StatusToggleController`

---

## 6. Publishing rules

- Content models use boolean `is_published`
- Public queries use `::published()` / `scopePublished()` → only Active items show on the website
- Admin list pages have Active/Inactive toggle
- Inactive = hidden from frontend, data remains in admin
- Users use `is_active` instead of `is_published`

---

## 7. Media uploads

- Shared helper: `app/Support/MediaUploader.php`
- Files stored on the `public` disk under folders such as `artworks`, `artists`, `hero`, etc.
- DB stores paths like `storage/artworks/...`
- Requires: `php artisan storage:link`
- Catalogue seed/master images may also live under `public/images/catalogue/`

---

## 8. Subdirectory deploy (`/dev/artsdiva`)

When hosted under a path prefix (not domain root):

1. `APP_URL` (and optionally `ASSET_URL`) must include the subdirectory  
2. `public/index.php` strips the base path from the request so routes match  
3. `AppServiceProvider` forces root URL + pagination path resolver  
4. `site_url()` / `site_page_url()` keep CMS and pager links under the app base  
5. Hero button URLs should be path-only (e.g. `catalogue`), not full absolute domain paths  

**Do not upload** local `bootstrap/cache/packages.php` / `services.php` to Hostinger if they reference packages not installed on the server. Prefer clearing caches and running `php artisan package:discover` on the server.

---

## 9. Auth & roles

| Role | Access |
|------|--------|
| `superadmin` | Full admin + Admins (users) |
| `admin` | CMS content (no user management) |
| `customer` | Account area only |

Middleware aliases registered in `bootstrap/app.php`.

---

## 10. Catalogue / search

- Listing + filters: `ArtworkRepository`
- Frontend search can match title, artist, serial, etc.
- Live suggest: `GET /catalogue/suggest` → `CatalogueController::suggest`

---

## 11. Useful scripts

| Script | Purpose |
|--------|---------|
| `scripts/upsert-masters-0001-0009.php` | Upsert master works 0001–0009 |
| `scripts/export-artwork-master-list.php` | Export serial / artist / title / description to `docs/` |
| `scripts/build-data-entry-docx.php` | Build Word data-entry guide |

---

## 12. Local / server ops (developer checklist)

```bash
composer install
cp .env.example .env   # configure DB, APP_URL
php artisan key:generate
php artisan migrate
php artisan storage:link
php artisan serve      # or Hostinger/Apache/Nginx → public/
```

Production: set mail SMTP for inquiries; set `APP_DEBUG=false`; keep `.env` off the public web root.

---

## 13. Related documentation

- Non-coder data entry: `docs/DATA-ENTRY-GUIDE.md` and `docs/ArtsDiva-Admin-Data-Entry-Guide.docx`
- Artwork inventory export: `docs/ARTWORK-MASTER-LIST.md` / `.csv` (generate via export script)
- Client scope confirmation: `docs/DEEP-SCOPE-CONFIRMATION.md`

---

*This document is the technical half of the handoff package requested for ArtsDiva.*
