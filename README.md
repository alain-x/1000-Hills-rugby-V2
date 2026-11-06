# 1000 Hills Rugby — Laravel site

A full rebuild of the 1000 Hills Rugby website on Laravel 12 with a public club website and a unified admin panel. All original club content — news, pages, staff, academy squads, events and partners — has been carried across from the legacy site.

## What is included

**Public website**

- Home page with featured news, next fixture, recent results, weekly schedule, squads and partners
- News listing and article pages with categories, search, galleries and article sections
- Fixtures and results with season, competition and squad filters
- League tables with competition, season and gender filters
- Teams index and squad pages with player filters and search
- Player profile pages
- Events listing, event detail pages and the weekly training schedule
- Staff & coaches, partners/sponsors, resources/downloads
- About, Academy, Foundation, Community, Education and Privacy pages
- Contact form and newsletter subscription
- Donations with Pesapal integration and a thank-you flow
- XML sitemap and SEO metadata

**Admin panel** (`/admin`)

Dashboard, news/articles, events, weekly schedule, pages, resources, teams, players, staff, sponsors, fixtures, standings, competitions, seasons, clubs, messages, donations, subscribers, users, settings and activity log. Uploads, slug generation, rich text (Quill), search, pagination and role-based access are supported.

## Requirements

- PHP 8.2 or newer with the usual Laravel extensions (`pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `gd` recommended)
- MySQL 8 / MariaDB
- Composer
- Apache with `mod_rewrite` (or Nginx)

No Node/npm build step is required. Bootstrap 5, Bootstrap Icons, Chart.js and Quill are vendored under `public/vendor/`.

## Local installation

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Create the database and update the `DB_*` values in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hillsrug_1000hills_rugby_db
DB_USERNAME=root
DB_PASSWORD=
```

Then run:

```bash
php artisan migrate:fresh --seed
php artisan serve
```

Open <http://127.0.0.1:8000>.

### Demo administrator accounts

| Role   | Identifier                    | Password         |
| ------ | ----------------------------- | ---------------- |
| Admin  | `admin@1000hillsrugby.rw`     | `Admin@1000hills` |
| Editor | `editor@1000hillsrugby.rw`    | `Editor@1000hills` |

The admin can also sign in with the username `admin` or `editor`. Change these credentials (and `ADMIN_EMAIL` / `ADMIN_PASSWORD` in `.env`) before going live.

The admin role has access to users, settings and the activity log. The editor role can manage content but not those areas.

## Seeded demo data

`DatabaseSeeder` runs these seeders:

- `AdminUserSeeder` — admin and editor accounts
- `SettingSeeder` — club details, social links, homepage and donation copy
- `PageSeeder` — About, Academy, Community, Education, Foundation and Privacy
- `TeamPlayerSeeder` — six squads and 43 players, including the legacy academy squads
- `CompetitionStandingSeeder` — men's/women's competitions, current and previous seasons, clubs and standings
- `ArticleSeeder` — eight real club stories with images and gallery content
- `EventScheduleSeeder` — upcoming and past events plus the weekly schedule
- `FixtureSeeder` — upcoming fixtures, recent results and previous-season results
- `SponsorStaffSeeder` — partners and the eight real staff profiles
- `ResourceSeeder` — activity calendar and official rugby resources
- `EngagementSeeder` — sample messages, donations, subscribers and activity history

Dates are seeded relative to the current year, so the fixtures, results and events remain populated whenever the site is installed.

## Uploads and media

Uploads are written to `public/uploads/{folder}` so the site works on shared hosting without a storage symlink. Existing legacy media lives in:

- `public/images/` — general club photography
- `public/imagesNews/` — news imagery
- `public/uploads/` — gallery and upload folders
- `public/logos_/` — partner and club logos
- `public/files/` — downloadable documents

Media paths are resolved with the `media_url()` helper, which also accepts full URLs.

## Donations (Pesapal)

Donation settings live in `config/pesapal.php` and are read from `.env`:

```env
PESAPAL_ENABLED=false
PESAPAL_ENV=sandbox
PESAPAL_CONSUMER_KEY=
PESAPAL_CONSUMER_SECRET=
PESAPAL_IPN_ID=
PESAPAL_CURRENCY=RWF
DONATION_MAX_RWF=2000000
FX_USD_RWF=1300
FX_EUR_RWF=1400
FX_GBP_RWF=1600
```

While `PESAPAL_ENABLED=false`, donations are recorded as pending and the donor is sent to the thank-you page with a message that the club will follow up. Set the credentials and enable it to redirect donors to Pesapal. Configure the Pesapal IPN URL as:

```text
https://your-domain.tld/donation/ipn
```

and the callback URL as:

```text
https://your-domain.tld/donation/callback
```

## Production deployment

1. Upload the project **above** the web root if possible, and point the virtual host document root at `public/`.
2. If the host only allows a single document root, the included root `.htaccess` forwards requests into `public/`:

   ```apache
   RewriteCond %{REQUEST_URI} !^/public/
   RewriteRule ^(.*)$ public/$1 [L]
   ```

   The root `.htaccess` also denies direct access to `.env`, Composer files and other application files.
3. Set `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://www.1000hillsrugby.rw` and `SESSION_SECURE_COOKIE=true`.
4. Set database and mail credentials.
5. Run:

   ```bash
   composer install --no-dev --optimize-autoloader
   php artisan key:generate
   php artisan migrate --force --seed
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

6. Make `storage/` and `bootstrap/cache/` writable by the web server, and make `public/uploads/` writable for admin uploads.
7. Schedule Laravel's scheduler if you add scheduled jobs (`* * * * * php /path/artisan schedule:run`).

If you re-run `migrate:fresh --seed` in production it will erase existing data. Use it only for a fresh demo install.

## Useful commands

```bash
php artisan migrate:fresh --seed   # rebuild the demo database
php artisan route:list             # inspect routes
php artisan optimize:clear         # clear config, route and view caches
php artisan about                  # environment summary
```

## Notes

- The original static/PHP site is preserved in `legacy/` for reference. It is not part of the running application.
- The site timezone is `Africa/Kigali`.
- Public URLs use clean slugs, for example `/news/women-national-league-one-of-a-kind`, `/teams/senior-women` and `/players/aline-uwase`.
- `public/robots.txt` allows the public site and disallows `/admin`; update the sitemap URL when the domain changes.
