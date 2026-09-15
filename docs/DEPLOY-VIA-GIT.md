# ArtsDiva — Deploy Live via Git (Hostinger)

## Current status (local)

- Project path: `d:\larvel`
- Git repo: **initialized** on branch `main`
- **Not yet committed / not yet on GitHub**
- Never commit: `.env`, `vendor/`, `node_modules/`, `storage` uploads

---

## One-time setup

### A) Local → GitHub

1. Create a **private** repo on GitHub (e.g. `artsdiva`).
2. On PC (PowerShell in `d:\larvel`):

```powershell
cd d:\larvel
git add .
git commit -m "ArtsDiva: prepare for Hostinger git deploy"
git remote add origin https://github.com/YOUR_USERNAME/artsdiva.git
git push -u origin main
```

(Replace `YOUR_USERNAME/artsdiva` with your real repo.)

### B) Hostinger server → pull from GitHub

SSH / Hostinger Terminal me (path adjust karo):

```bash
cd ~/domains/pixxelu.com/public_html/dev/artsdiva

# First time only (if folder already has files from FTP):
# Option 1 — recommended: backup, then fresh clone into a temp folder and swap
# Option 2 — init git in existing folder and pull:

git init -b main
git remote add origin https://github.com/YOUR_USERNAME/artsdiva.git
git fetch origin
git checkout -f main

# Keep production env (do NOT overwrite .env from git)
# Ensure .env exists with APP_URL, DB_*, ASSET_URL for /dev/artsdiva

composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan storage:link
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

**Important:** Hostinger pe `composer` / `proc_open` kabhi block hota hai. Agar `composer install` fail ho, `vendor` pehle se server pe hona chahiye (pehle se deployed) — sirf app code `git pull` se update karo.

---

## Har baar naya code live karna (daily workflow)

### Local

```powershell
cd d:\larvel
git add .
git commit -m "Describe your change"
git push origin main
```

### Live (SSH)

```bash
cd ~/domains/pixxelu.com/public_html/dev/artsdiva
git pull origin main
php artisan view:clear
php artisan cache:clear
# agar migration ho:
# php artisan migrate --force
```

---

## Hostinger hPanel Git (no SSH)

1. hPanel → **Git**
2. Create repository / connect GitHub repo
3. Deploy path = `public_html/dev/artsdiva` (ya jo actual Laravel root hai)
4. Branch = `main`
5. Deploy / Pull

Document root must still point at Laravel’s **`public`** folder (or your existing `/dev/artsdiva` public setup).

---

## Checklist before first push

- [ ] GitHub private repo created  
- [ ] First commit + push from local  
- [ ] Server has working `.env` (not from git)  
- [ ] `storage` and `bootstrap/cache` writable  
- [ ] Do **not** upload local `bootstrap/cache/packages.php` that breaks Hostinger  
- [ ] After pull: clear view/cache  

---

## What Rakesh needs from you to finish this

1. GitHub username + repo name (or create repo and share URL)  
2. Confirm Hostinger SSH / Terminal access (yes/no)  
3. Exact live folder path (confirm: `.../public_html/dev/artsdiva`)  

Then we can run the first commit + push together.
