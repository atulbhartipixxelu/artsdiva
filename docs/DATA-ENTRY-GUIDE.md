# ArtsDiva Admin — Data Entry Guide (Non-Technical)

**Login URL:** `https://pixxelu.com/dev/artsdiva/admin/login`  
**Who this is for:** Interns / content team who upload artists, artworks, and other site content.

---

## 0) Login & basic rules

1. Open the login URL above.
2. Enter email + password given by admin.
3. Left sidebar = all sections you can manage.
4. **Active / Inactive** toggle on every list:
   - **Active (Published)** = shows on the public website
   - **Inactive** = hidden from website (still saved in admin)
5. Always click **Save** after filling a form.
6. Image tips: JPG/PNG/WebP preferred; keep files under ~2–5 MB when possible.

**Correct upload order for catalogue work:**
1. First create **Artist**
2. Then create **Artwork** and select that artist

---

## 1) Dashboard menu — what each item is for

| # | Menu item | Uploads / manages | Shows on website |
|---|-----------|-------------------|------------------|
| 1 | **Artworks** | Paintings / works (title, serial, image, price, etc.) | Catalogue + home featured |
| 2 | **Artists** | Artist profile (name, bio, photo) | Artists page + artwork credit |
| 3 | **Hero Slides** | Home page big banner images + buttons | Home page top slider |
| 4 | **Exhibitions** | Exhibition cards | Exhibitions page |
| 5 | **Events** | Event cards | Events page |
| 6 | **News** | News articles | News page |
| 7 | **Publications** | Books / press / publication cards | Publications page |
| 8 | **Pages** | About / Leasing / Contact page text | Those fixed pages |
| 9 | **Inquiries** | Form messages from visitors (view only — no upload) | Admin only |
| 10 | **Admins** | Staff login accounts (superadmin only) | Admin only |

---

## 2) How to upload an ARTIST (step by step)

1. Sidebar → **Artists**
2. Click **Add Artist** (or similar “Add” button)
3. Fill fields:

| Field | Required? | What to enter |
|-------|-----------|---------------|
| **Name** | Yes | Full artist name (e.g. Frida Kahlo) |
| **Slug** | No | Leave blank — system can create it |
| **City** | No | e.g. Mexico City |
| **Country** | No | e.g. Mexico |
| **Bio** | No | Short artist biography |
| **Image** | Recommended | Artist photo / portrait |
| **Sort order** | No | Number for display order (0 = default) |
| **Published** | Tick if ready | Must be checked to show on site |
| **Featured** | Optional | Highlight on site if needed |

4. Click **Save**
5. Confirm artist appears in Artists list with **Active** status

---

## 3) How to upload an ARTWORK (step by step)

**Do this only after the artist already exists.**

1. Sidebar → **Artworks**
2. Click **Add Artwork**
3. Fill fields:

| Field | Required? | What to enter |
|-------|-----------|---------------|
| **Title** | Yes | Artwork name (e.g. The Two Fridas) |
| **Serial number** | Yes | Unique ID like `0001`, `0010` — never reuse |
| **Slug** | No | Leave blank unless you know what you’re doing |
| **Artist** | Recommended | Select from dropdown (must exist first) |
| **Category** | No | e.g. Painting, Print |
| **City** | No | Location related to work if any |
| **Price (EUR)** | Yes | Number only (e.g. `45000`). Use `0` if not for sale |
| **Dimensions** | No | e.g. `173.5 × 173 cm` |
| **Weight** | No | If known |
| **Year** | No | e.g. `1939` |
| **Medium** | No | e.g. Oil on canvas |
| **Description** | Recommended | Full description text for the detail page |
| **Thumbnail** | Recommended | Main catalogue image (card image) |
| **Gallery images** | Optional | Extra detail-page photos (multiple allowed) |
| **Sort order** | No | Display order number |
| **Published** | Tick if ready | Required to show on catalogue |
| **Featured** | Optional | Show on home / featured areas |

4. Click **Save**
5. Open **View Website** → Catalogue and search by serial or title to verify

### Serial number rules
- Must be **unique** for every artwork
- Prefer 4-digit style: `0001`, `0002`, …
- Used for inventory tracking and website search

### Image checklist before upload
- Correct artwork (not wrong painting / wrong edition)
- Clear, high quality
- Correct orientation (not sideways)
- Thumbnail = main face of the work

---

## 4) Other content upload lists

### A) Hero Slides (home banner)
| Field | Notes |
|-------|--------|
| Eyebrow | Small top line |
| Title * | Main headline |
| Subtitle | Supporting line |
| Button 1 label / URL | e.g. label `Catalogue`, URL `catalogue` |
| Button 2 label / URL | e.g. `leasing-inquiry` |
| Image | Large banner image |
| Published | Tick to show |

**URL tip:** write path only (`catalogue`), not full website URL.

### B) Exhibitions
Title*, Slug, Subtitle, Dates, Location, Description, Image, Sort order, Published

### C) Events
Title*, Slug, Tags (comma separated), Date label, Time label, Location, Description, Image, Sort order, Published

### D) News
Title*, Slug, Published at (date/time), Image, Excerpt, Body, Published

### E) Publications
Artist name*, Title*, Slug, Link URL, Excerpt, Image, Sort order, Published

### F) Pages (About / Leasing / Contact)
Title*, Subtitle, Body (HTML allowed), CTA label/URL, Meta description, Image, Published  
(Slug is fixed — do not change)

### G) Inquiries
No upload. Only read / manage visitor form submissions.

### H) Admins (superadmin only)
Create staff users; Active/Inactive controls login access.

---

## 5) Daily checklist for interns

- [ ] Artist exists before artwork
- [ ] Serial number unique and written correctly
- [ ] Correct image attached (double-check against client file name)
- [ ] Title + description match client brief
- [ ] Artist selected in artwork form
- [ ] **Published / Active** turned on when ready for public site
- [ ] After save, check website Catalogue page
- [ ] If something looks wrong → turn **Inactive** immediately, then edit and fix

---

## 6) Quick troubleshooting

| Problem | Fix |
|---------|-----|
| Artwork not on website | Check **Active/Published** toggle; clear browser refresh |
| Artist missing in artwork dropdown | Create artist first, then reopen artwork form |
| “Serial already taken” | Choose a new unused serial |
| Wrong image showing | Edit artwork → upload new Thumbnail → Save |
| Hero button goes to wrong page | Use short path like `catalogue`, not full domain URL |

---

*Last updated for ArtsDiva admin CMS (Laravel).*
