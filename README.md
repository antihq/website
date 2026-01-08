# Anti Starter Kit

A modern Laravel 12 starter kit built with Livewire v4, Flux UI Pro, and Pest testing.

[![Laravel](https://img.shields.io/badge/Laravel-12-red)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.4-blue)](https://php.net)
[![Livewire](https://img.shields.io/badge/Livewire-4-pink)](https://livewire.laravel.com)
[![Pest](https://img.shields.io/badge/Pest-4-purple)](https://pestphp.com)
[![License](https://img.shields.io/badge/License-O%27Saasy-green)](https://osaasy.dev)

> ⚠️ **Flux Pro Required**

## About

Anti Starter Kit is a production-ready Laravel starter kit featuring Livewire v4's single-file components, Flux UI Pro components, and comprehensive team management. Built with modern best practices, it includes authentication, two-factor authentication, team collaboration features, and browser testing out of the box.

This starter kit provides everything you need to build a modern web application with Laravel, including responsive design, dark mode, and a full suite of testing tools.

## Tech Stack

### Backend

- **Laravel 12** - PHP framework
- **Livewire v4** - Dynamic components (single-file)
- **PHP 8.4** - Programming language
- **Laravel Jetstream** - Authentication scaffolding
- **Laravel Fortify** - Backend authentication
- **Laravel Sanctum** - API authentication

### Frontend

- **Flux UI Pro v2** - Livewire component library
- **Tailwind CSS v4** - Utility-first CSS
- **Vite 7** - Build tool & dev server
- **Inter** - Font family

### Testing & Quality

- **Pest v4** - Testing framework (feature, unit, browser)
- **Laravel Pint** - PHP code formatter
- **Prettier** - Blade & JS formatter

## Features

- ✅ Authentication (login, registration, password reset)
- ✅ Two-factor authentication
- ✅ Email verification
- ✅ Team management (create teams, invite members, switch teams)
- ✅ User profiles with photo upload
- ✅ API token management
- ✅ Device/session management
- ✅ Dark mode support
- ✅ Responsive design (mobile-first)
- ✅ Single-file Livewire components
- ✅ Flux UI Pro components
- ✅ Browser testing with Pest v4
- ✅ Server timing middleware
- ✅ Honeybadger error tracking
- ✅ Queue workers included

## Requirements

- PHP 8.4+
- Composer 2+
- Node.js 22+
- npm
- Laravel Herd (recommended) or PHP built-in server
- **Flux Pro license** (required for Pro components)

## Flux UI Pro Setup

This starter kit uses Flux UI Pro components. To set up:

1. Obtain a Flux Pro license from https://fluxui.dev
2. Configure your credentials:

```bash
composer config http-basic.composer.fluxui.dev "YOUR_USERNAME" "YOUR_LICENSE_KEY"
composer update livewire/flux-pro
```

3. Verify installation:

```bash
composer show livewire/flux-pro
```

All Flux Pro components are now available via `<flux:*>` tags in your Blade views.

## Installation

```bash
# 1. Clone the repository
git clone https://github.com/antihq/livewire-starter-kit.git
cd livewire-starter-kit

# 2. Run the setup script (installs dependencies, generates key, migrates database, builds assets)
composer setup

# 3. Configure environment (if needed)
cp .env.example .env
php artisan key:generate

# 4. Start the development server
composer dev
```

Access via Laravel Herd at `https://livewire-starter-kit.test`

## Available Scripts

### Composer Scripts

- `composer setup` - Full project setup (install, migrate, build)
- `composer dev` - Start all development services (server, queue, logs, Vite)
- `composer test` - Run Pest test suite
- `vendor/bin/pint` - Format PHP code

### NPM Scripts

- `npm run dev` - Start Vite dev server with hot reload
- `npm run build` - Build assets for production

## Development Workflow

### Running the Application

**Option 1: Full Development Environment (Recommended)**

```bash
composer dev
```

This runs:

- Laravel development server
- Queue worker
- Live logs with Pail
- Vite dev server

**Option 2: Individual Services**

```bash
php artisan serve              # Laravel server on port 8000
php artisan queue:listen       # Queue worker
php artisan pail              # Live logs
npm run dev                   # Vite dev server
```

### Creating Livewire Components

```bash
# Single-file component (default - recommended)
php artisan make:livewire pages.dashboard

# Multi-file component
php artisan make:livewire pages.dashboard --mfc

# Convert between formats
php artisan livewire:convert pages.dashboard
```

### Code Quality

```bash
# Format PHP code
vendor/bin/pint

# Format Blade & JavaScript (runs automatically on commit)
npx prettier --write .
```

### Testing

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/Auth/AuthenticationTest.php

# Run tests matching pattern
php artisan test --filter="login"
```

## Project Structure

```
antihq-livewire-starter-kit/
├── app/
│   ├── Livewire/
│   │   └── Actions/              # Livewire action components
│   ├── Models/                   # Eloquent models (User, Team, Membership)
│   └── Policies/                 # Authorization policies
├── resources/
│   ├── views/
│   │   ├── pages/                # Single-file Livewire components (⚡)
│   │   │   ├── account/
│   │   │   └── teams/
│   │   ├── components/           # Reusable Blade components (⚡)
│   │   │   ├── account/
│   │   │   └── api-tokens/
│   │   └── layouts/
│   │       ├── auth/
│   │       └── app/
│   ├── css/
│   │   └── app.css              # Tailwind imports + custom theme
│   └── js/
│       └── app.js               # JavaScript entry point
├── tests/
│   ├── Feature/                 # Feature tests
│   ├── Unit/                    # Unit tests
│   └── Browser/                 # Browser tests (Pest v4)
├── routes/
│   ├── web.php                  # Web routes
│   └── api.php                  # API routes
└── bootstrap/
    └── app.php                  # Application bootstrap
```

## Customization

### App Name & Branding

Update the application name in your `.env` file:

```env
APP_NAME=Your App Name
```

Customize the logo in `resources/views/components/app-logo.blade.php`.

### Color Theme

Edit theme colors in `resources/css/app.css`. The current theme uses:

- Accent color: Green (customizable)
- Zinc scale: Grays/neutral colors
- Blue, Green, Red, Yellow scales: Status colors

Example - changing accent to blue:

```css
@theme {
    --color-accent: var(--color-blue-600);
    --color-accent-content: var(--color-blue-700);
    --color-accent-foreground: var(--color-white);
}
```

### Flux Components

This starter kit includes access to all Flux UI Pro components:

- **Form**: button, input, select, checkbox, radio, switch, textarea, autocomplete, otp-input
- **Data**: table, pagination, kanban, chart
- **Layout**: card, modal, dropdown, popover, tabs, accordion, separator, skeleton
- **Navigation**: navbar, sidebar, breadcrumbs, tabs
- **Display**: avatar, badge, icon, text, heading, callout, toast, tooltip
- **Advanced**: editor, calendar, date-picker, time-picker, slider, command, context, file-upload

See full documentation: https://fluxui.dev/components

### Authentication Features

Enable or disable authentication features in `config/jetstream.php`:

```php
'features' => [
    'terms' => false,               // Terms of service
    'policy' => false,               // Privacy policy
    'two-factor-authentication' => true,
    'api' => true,                   // API tokens
    'teams' => ['invitations' => true],
    'account-deletion' => true,
    'profile-photos' => true,
],
```

### Team Features

Configure team behavior in `config/jetstream.php`:

```php
'teams' => [
    'invitations' => true,           // Team invitations
    'default' => false,              // Create team on registration
],
```

### Database Configuration

**SQLite (Default)**

```env
DB_CONNECTION=sqlite
```

**MySQL**

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=root
DB_PASSWORD=
```

**PostgreSQL**

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=your_db_name
DB_USERNAME=postgres
DB_PASSWORD=
```

## Testing

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/DashboardTest.php

# Filter by test name
php artisan test --filter="user_can_login"

# Generate coverage report
php artisan test --coverage
```

### Test Types

- **Feature Tests** - Full request/response testing
- **Unit Tests** - Isolated method testing
- **Browser Tests** - Real browser automation (Pest v4)

### Writing Browser Tests

```php
it('user can login', function () {
    $user = User::factory()->create();

    visit('/login')
        ->fill('email', $user->email)
        ->fill('password', 'password')
        ->click('Sign In')
        ->assertSee('Dashboard')
        ->assertNoJavascriptErrors();
});
```

### Test Coverage

Run tests with coverage:

```bash
php artisan test --coverage --min=80
```

## Screenshots

<!-- SCREENSHOT: Dashboard view showing main layout with placeholder cards and sidebar -->

![Dashboard](/screenshots/dashboard.png)

<!-- SCREENSHOT: Login page with authentication form -->

![Login](/screenshots/login.png)

<!-- SCREENSHOT: Profile page with photo upload and user information form -->

![Profile](/screenshots/profile.png)

<!-- SCREENSHOT: Team settings page showing team management options -->

![Team Settings](/screenshots/team-settings.png)

<!-- SCREENSHOT: Team members page with member list and invitation form -->

![Team Members](/screenshots/team-members.png)

<!-- SCREENSHOT: Dark mode enabled showing dark theme across interface -->

![Dark Mode](/screenshots/dark-mode.png)

<!-- SCREENSHOT: Mobile responsive view with hamburger menu -->

![Mobile](/screenshots/mobile.png)

> **Note**: Add screenshots to `/screenshots/` directory and update paths above

## Troubleshooting

### Flux Pro Not Working

**Error**: "livewire/flux-pro" package not found

**Solution**:

```bash
composer config http-basic.composer.fluxui.dev "YOUR_USERNAME" "YOUR_LICENSE_KEY"
composer update livewire/flux-pro
```

### Vite Build Errors

**Error**: "Unable to locate file in Vite manifest"

**Solution**:

```bash
npm run build  # For production
# OR
npm run dev   # For development
```

### Missing Assets After Deployment

**Error**: 404 on CSS/JS files

**Solution**:

```bash
npm run build
# Verify public/build/ directory exists
```

### Tests Failing - Database Connection

**Error**: Database connection failed

**Solution**:

```bash
touch database/database.sqlite
php artisan migrate:fresh
php artisan test
```

### Dark Mode Not Persisting

**Issue**: Dark mode resets on page refresh

**Solution**:

- Check localStorage is enabled in browser
- Verify dark mode logic in `resources/views/pages/account/⚡appearance.blade.php`
- Ensure `@persist` directives are used for state preservation

### Two-Factor Authentication Disabled

**Issue**: 2FA options not showing

**Solution**:

Enable in `config/jetstream.php`:

```php
'features' => [
    'two-factor-authentication' => true,
],
```

### Livewire Components Not Loading

**Error**: Component not found or not rendering

**Solution**:

```bash
php artisan view:clear
php artisan config:clear
php artisan cache:clear
php artisan route:clear
```

### Server Timing Middleware Issues

**Error**: Server timing header errors in production

**Solution**:

Comment out in `bootstrap/app.php`:

```php
// $middleware->prepend(\BeyondCode\ServerTiming\Middleware\ServerTimingMiddleware::class);
```

### Honeybadger Not Reporting

**Issue**: Errors not being sent to Honeybadger

**Solution**:

Set API key in `.env`:

```env
HONEYBADGER_API_KEY=your_api_key
HONEYBADGER_VERIFY_SSL=true
```

### Assets Not Hot Reloading

**Issue**: Changes to CSS/JS not reflecting

**Solution**:

```bash
# Stop Vite server and restart
npm run dev

# Or rebuild
npm run build && composer dev
```

### Queue Jobs Not Processing

**Issue**: Queued jobs stuck in pending state

**Solution**:

```bash
# Ensure queue worker is running
php artisan queue:listen

# Check queue configuration in .env
QUEUE_CONNECTION=database

# Clear failed jobs
php artisan queue:flush
```

## CI/CD

### GitHub Actions Workflows

This repository includes two GitHub Actions workflows:

**`.github/workflows/tests.yml`**

- Runs on push/PR to develop and main branches
- Sets up PHP 8.4 and Node.js 22
- Runs full test suite

**`.github/workflows/lint.yml`**

- Runs on push/PR to develop and main branches
- Runs Laravel Pint formatter
- Auto-commits style fixes (currently commented out)

### Required GitHub Secrets

Add these secrets in your repository settings:

```
Settings → Secrets and variables → Actions → New repository secret
```

- `FLUX_USERNAME` - Your Flux Pro username
- `FLUX_LICENSE_KEY` - Your Flux Pro license key

## Code Style

### PHP Code Formatting

Uses Laravel Pint with Laravel's default style.

```bash
# Format all PHP files
vendor/bin/pint

# Format specific directory
vendor/bin/pint app

# Check without fixing
vendor/bin/pint --test
```

Pint is configured in `composer.json` and runs automatically in CI/CD.

### Blade & JavaScript Formatting

Uses Prettier with Tailwind and Blade plugins.

```bash
# Format all files
npx prettier --write .

# Format specific file types
npx prettier --write "**/*.{blade.php,js,css,json}"
```

## Credits & License

Built by [Oliver Servín](https://x.com/oliverservinX)

**Contact**: oliver@antihq.com

**Repository**: https://github.com/antihq/livewire-starter-kit

### License

This project is licensed under the [O'Saasy License](LICENSE).

## Contributing

Contributions are welcome! Please follow these guidelines:

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/amazing-feature`
3. Write/update tests for your changes
4. Ensure all tests pass: `php artisan test`
5. Format your code: `vendor/bin/pint && npx prettier --write .`
6. Commit your changes: `git commit -m 'Add amazing feature'`
7. Push to the branch: `git push origin feature/amazing-feature`
8. Open a Pull Request

### Code of Conduct

By participating in this project, you agree to maintain a respectful and inclusive environment.
