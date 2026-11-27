# Figs & Olives Bookstore

A custom rebuild of the Figs & Olives Publications WordPress/WooCommerce store.

**Stack:** Laravel 13, PHP 8.5, Filament 5 (admin), Livewire, Tailwind, MySQL, Pest.

## Requirements

- PHP 8.5, Composer, Node.js and npm
- MySQL
- Windows with [Laravel Herd](https://herd.laravel.com) (the site runs at `http://bookstore.test`)

## Setup (PowerShell)

```powershell
git clone https://github.com/ze1820/bookstore.git C:\dev\bookstore
cd C:\dev\bookstore
composer install
npm install
copy .env.example .env
php artisan key:generate
```

Edit `.env` and set your own database name, user and password, then run:

```powershell
php artisan migrate
php artisan storage:link
npm run build
```

`storage:link` is required so uploaded images and demo PDFs can be reached.

### Admin user

The admin panel is at `/admin`. Local email is not delivered, so new users stay unverified. Verify a user in tinker:

```powershell
php artisan tinker
>>> App\Models\User::where('email', 'you@example.com')->update(['email_verified_at' => now()]);
```

## Daily workflow

```powershell
git pull
git checkout -b feature/short-name
# work, then:
php artisan optimize:clear
php artisan test
git add .
git commit -m "Describe the change"
git push -u origin feature/short-name
```

Open a Pull Request on GitHub and merge after review. Avoid pushing directly to `main`.

Never commit `.env`, `vendor/` or `node_modules/`.

## Rules learned the hard way

- **Never create PHP files with `Set-Content -Encoding utf8`.** It adds a BOM and PHP fails with "Namespace declaration statement has to be the very first statement". Create files in VS Code. To fix a BOM, rewrite the file with `UTF8Encoding($false)`.
- `php artisan make:livewire` generates a single-file view component here, not a class. `app/Livewire/ContactForm.php` was created by hand.
- Run `php artisan optimize:clear` after adding classes, then `php artisan test`.
- Commands should be PowerShell-compatible.
- PHP's `upload_max_filesize` and `post_max_size` must be at least 20 MB for demo PDF uploads.

## Project structure

- **Models:** `Author`, `Book`, `BookImage`, `Category`, `FormSubmission`, `User`
- **Public routes:** `/`, `/shop`, `/books/{book:slug}`, `/contact`, `/volunteer`, `/authors`
- **Public views:** use `<x-shop-layout title="..." description="...">` and `<x-book-card :book="$book" />`. `layouts/app.blade.php` is the Flux dashboard layout and is not for public pages.
- **Tailwind tokens:** `bg-brand`, `bg-brand-dark`, `text-ink`
- **Admin (`/admin`):** Authors, Books, Inbox
- **Forms:** `App\Livewire\ContactForm` is reusable for contact, volunteer and mentorship through a `type` property, with validation, a honeypot field (`website`) and rate limiting (5 per hour per IP and type). Submissions are stored in `form_submissions`.
- **Inbox:** read-only Filament resource in `app/Filament/Resources/FormSubmissions/`

## Features

- Book cards cross-fade between a book's images. The book page has a slideshow gallery.
- Optional demo PDF per book, with a "Read a free sample" tab and a badge on cards.
- Shop page: category pills, search, sort, result count, Sold out and "Only N left" labels (threshold is 5, set in `getIsLowStockAttribute` in `Book.php`).

## Status

- Cart and checkout are **on hold** until the client answers questions about currency, tax, shipping, discounts, past orders, brand assets, and payment access. "Sold out" is display-only for now.
- The storefront redesign and the latest shop changes were written without running the app. Test them locally and report any error or odd layout.

### Next steps

1. Policy pages (Returns, Shipping, Privacy, Terms) with placeholder text
2. Mentorship application form, reusing `ContactForm`
3. Email notification when a message arrives (needs a real mail service)
4. Security and SEO: sanitize book descriptions, 2FA for admin, 301 redirects from old WordPress URLs
5. After client answers: cart, shipping and tax, checkout, Stripe and PayPal with webhooks, order emails, staging, launch

For more detail, see `HANDOFF.md` if it is present in the repo.
