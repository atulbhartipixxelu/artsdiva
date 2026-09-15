# ArtsDiva — Client-Facing Website

Laravel public website for **ArtsDiva** fine art acquisition and annual leasing.

## Admin dashboard

Open: [http://127.0.0.1:8000/admin/login](http://127.0.0.1:8000/admin/login)

| Role | Email | Password |
|------|-------|----------|
| Superadmin | `superadmin@artsdiva.com` | `password` |
| Admin | `admin@artsdiva.com` | `password` |

Superadmin can manage other admin users. Admins can manage all website content (artworks, artists, events, news, publications, pages, hero slides, enquiries).

Re-seed demo data:

```bash
php artisan migrate:fresh --seed
```


```bash
# If OpenSSL is missing from the default PHP, set PHPRC to the project helper ini:
#   set PHPRC=d:\php-local-laravel.ini   (Windows)
php artisan serve
```

Open: [http://127.0.0.1:8000](http://127.0.0.1:8000)

## What’s included

| Area | Status |
|------|--------|
| Home (gallery-style layout from approved mockup) | Done |
| Catalogue grid + filters/sort | Done |
| Artwork detail (gallery, specs, lease estimate) | Done |
| Currency selector (USD, EUR, INR, CNY, JPY) | Done |
| Leasing inquiry form + confirmation | Done |
| Placeholder artworks (`config/artworks.php`) | Done |
| On-page SEO (titles, meta, alt text) | Done |
| Responsive / mobile-first CSS | Done |

## Configuration

- Inquiry email: `ARTSDIVA_INQUIRY_EMAIL` in `.env` (default `inquiries@artsdiva.com`)
- Mail: set `MAIL_MAILER` / SMTP when the live inbox is ready (currently `log` for staging)
- Lease tiers & FX rates: `config/artsdiva.php`

## Lease rate assumption (flag for client)

Brief: under €25,000 = **10% per annum**, scaling down for higher value.

Implemented tiers pending confirmation:

| EUR value | Annual lease rate |
|-----------|-------------------|
| &lt; 25,000 | 10% |
| 25,000 – 49,999 | 8% |
| 50,000 – 99,999 | 6.5% |
| ≥ 100,000 | 5% |

## Open questions

1. Exact intermediate lease tiers above €25k (only the first band was specified).
2. Final inquiry inbox address and SMTP credentials.
3. Domain / subdomain for staging vs production.
4. When real artwork assets replace Unsplash placeholders.

## Notes

- This phase is front-end only; catalogue data lives in config (no intranet integration).
- Branding uses **ArtsDiva** with the visual structure of the provided home mockup.
