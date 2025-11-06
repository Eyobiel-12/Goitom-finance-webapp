# Goitom Finance

## ⚠️ Important: Asset Management

**ALWAYS use `@vite` directives in Blade templates. NEVER hardcode asset paths.**

See [docs/ASSET_MANAGEMENT.md](docs/ASSET_MANAGEMENT.md) for details.

```blade
{{-- ✅ Correct --}}
@vite(['resources/css/app.css', 'resources/js/app.js'])

{{-- ❌ Wrong --}}
<link rel="stylesheet" href="{{ asset('build/assets/app-XXX.css') }}">
```

**Goitom Finance** — Enterprise SaaS voor Habesha Freelancers

[![Laravel](https://img.shields.io/badge/Laravel-11-red)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/Livewire-3-orange)](https://livewire.laravel.com)
[![Filament](https://img.shields.io/badge/Filament-3-blue)](https://filamentphp.com)
[![PostgreSQL](https://img.shields.io/badge/PostgreSQL-15-blue)](https://www.postgresql.org)

**Goitom Finance** is een enterprise-grade SaaS applicatie speciaal ontwikkeld voor Habesha freelancers en ondernemers om hun financiën te beheren. De applicatie biedt klantbeheer, projecttracering, facturering, betalingen en BTW-rapportage.

## 🎯 Features

### Core Functionaliteit

-   ✅ **Multi-tenant architectuur** met organisatie-scoping
-   ✅ **Klant Management** met volledige contactinformatie
-   ✅ **Project Tracking** met status en uren bijhouden
-   ✅ **Factuur Generatie** met professionele PDFs
-   ✅ **Betalingen Beheer** met meerdere betaalmethoden
-   ✅ **BTW Rapportage** voor fiscale compliance
-   ✅ **Dashboard Statistieken** met real-time data
-   ✅ **Dark Theme** met luxe black & gold design

### Admin Functionaliteit

-   ✅ **Filament Admin Panel** voor organisatie beheer
-   ✅ **User Management** met role-based access control
-   ✅ **Organisatie Settings** met branding opties
-   ✅ **Audit Logging** voor compliance

### Technische Features

-   ✅ **RESTful API** met Sanctum authenticatie
-   ✅ **PDF Generatie** met Browsershot
-   ✅ **Queue System** voor achtergrond taken
-   ✅ **Encrypted Data** voor gevoelige informatie
-   ✅ **Responsive Design** voor alle apparaten

## 🛠 Tech Stack

### Backend

-   **Laravel 11** - PHP framework
-   **Livewire 3** - Reactive UI components
-   **Filament 3** - Admin panel
-   **PostgreSQL** - Database
-   **Redis** - Queue & cache
-   **Laravel Sanctum** - API authenticatie
-   **Spatie Permissions** - RBAC
-   **Browsershot** - PDF generatie

### Frontend

-   **Tailwind CSS** - Utility-first CSS
-   **Bootstrap 5** - UI framework
-   **Alpine.js** - JavaScript framework
-   **Blade Templates** - Server-side rendering

### DevOps

-   **Laravel Horizon** - Queue monitoring
-   **Laravel Telescope** - Debugging
-   **Docker** - Containerization
-   **GitHub Actions** - CI/CD

## 📁 Project Structuur

```

goitom-finance/
├── app/
│ ├── Filament/ # Admin panel resources
│ ├── Http/
│ │ ├── Controllers/ # API & web controllers
│ │ └── Middleware/ # Custom middleware
│ ├── Jobs/ # Queue jobs
│ ├── Livewire/ # Livewire components
│ ├── Models/ # Eloquent models
│ ├── Policies/ # Authorization policies
│ ├── Services/ # Business logic
│ └── View/ # Blade components
├── database/
│ ├── migrations/ # Database schema
│ └── seeders/ # Test data
├── resources/
│ ├── views/
│ │ ├── app/ # Main application views
│ │ ├── invoices/ # Invoice PDF templates
│ │ └── livewire/ # Livewire views
│ └── scss/ # Custom styles
├── routes/
│ ├── api.php # API endpoints
│ └── web.php # Web routes
└── tests/ # Unit & feature tests
```

## 🚀 Installatie

### Vereisten

-   PHP 8.2+
-   Composer
-   PostgreSQL 15+
-   Node.js & npm
-   Redis (optioneel voor queues)

### Setup

1. **Clone repository**

```bash
git clone https://github.com/yourusername/goitom-finance.git
cd goitom-finance
```

2. **Installeer dependencies**

```bash
composer install
npm install
```

3. **Configureer environment**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Configureer database in `.env`**

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=goitom_finance
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. **Run migrations**

```bash
php artisan migrate:fresh --seed
```

6. **Build assets**

```bash
npm run build
php artisan storage:link
```

7. **Start development server**

```bash
php artisan serve
```

## 👤 Gebruikers

Na installatie zijn deze gebruikers beschikbaar:

-   **Admin**: `admin@goitom-finance.com` / `password`
-   **Ondernemer**: `ondernemer@example.com` / `password`

## 📊 Database Schema

### Hoofdtabellen

-   `organizations` - Organisaties met encrypted VAT nummers
-   `users` - Multi-tenant gebruikers met roles
-   `clients` - Klanten met contactgegevens
-   `projects` - Projecten met status tracking
-   `invoices` - Facturen met line items
-   `invoice_items` - Factuurregels met BTW berekeningen
-   `payments` - Betalingen per factuur
-   `vat_reports` - BTW rapporten
-   `templates` - PDF/email templates
-   `audit_logs` - Audit trail

## 🔐 Beveiliging

### Authentication

-   Laravel Breeze voor web authenticatie
-   Laravel Sanctum voor API tokens
-   Email verificatie
-   Password reset flow

### Authorization

-   Role-based access control (RBAC)
-   Policy-based authorization
-   Multi-tenant data isolation
-   Organization-scoped queries

### Data Protection

-   Encrypted VAT numbers
-   Secure file storage (S3 ready)
-   CSRF protection
-   SQL injection prevention

## 🧪 Testing

### Run Tests

```bash
# Alle tests
php artisan test

# Alleen unit tests
php artisan test --testsuite=Unit

# Alleen feature tests
php artisan test --testsuite=Feature

# Met coverage
php artisan test --coverage
```

## 📱 API Documentatie

### Authentication

```bash
# Login en token ophalen
POST /api/login
{
  "email": "user@example.com",
  "password": "password"
}

# Verificatie
Header: Authorization: Bearer {token}
```

### Endpoints

#### Facturen

-   `GET /api/v1/invoices` - Lijst facturen
-   `POST /api/v1/invoices` - Nieuwe factuur
-   `GET /api/v1/invoices/{id}` - Factuur details
-   `PUT /api/v1/invoices/{id}` - Update factuur
-   `DELETE /api/v1/invoices/{id}` - Verwijder factuur
-   `POST /api/v1/invoices/{id}/send` - Verzend factuur
-   `POST /api/v1/invoices/{id}/mark-paid` - Markeer als betaald
-   `GET /api/v1/invoices/{id}/pdf` - PDF download

#### Klanten

-   `GET /api/v1/clients` - Lijst klanten
-   `POST /api/v1/clients` - Nieuwe klant
-   `GET /api/v1/clients/{id}` - Klant details
-   `PUT /api/v1/clients/{id}` - Update klant
-   `DELETE /api/v1/clients/{id}` - Verwijder klant
-   `GET /api/v1/clients/{id}/invoices` - Klant facturen
-   `GET /api/v1/clients/{id}/projects` - Klant projecten

## 🎨 Styling

### Theme

-   **Primary**: Black (`#0b0b0b`)
-   **Secondary**: Gold (`#d4af37`)
-   **Accent**: Cream (`#faf8f2`)

### Components

-   Tailwind CSS utility classes
-   Custom SCSS voor branding
-   Dark mode support
-   Responsive breakpoints

## 📈 Monitoring

### Queue Monitoring

```bash
php artisan horizon
```

### Debugging

```bash
php artisan telescope:publish
```

### Logs

```bash
tail -f storage/logs/laravel.log
```

## 🚢 Deployment

### Productie Checklist

-   [ ] Environment variabelen configureren
-   [ ] Database backups instellen
-   [ ] SSL certificaat configureren
-   [ ] Queue workers starten
-   [ ] Cache optimiseren
-   [ ] Storage link maken

### Commands

```bash
# Cache optimalisatie
php artisan optimize

# Queue workers
php artisan queue:work --daemon

# Scheduler
php artisan schedule:run
```

## 🤝 Bijdragen

Bijdragen zijn welkom! Voel je vrij om een issue of pull request te maken.

## 📄 Licentie

Dit project is eigendom van Goitom Finance BV.

## 👥 Contact

Voor vragen of support, neem contact op via [info@goitom-finance.com](mailto:info@goitom-finance.com)

---

**Gemaakt met ❤️ voor de Habesha community**
