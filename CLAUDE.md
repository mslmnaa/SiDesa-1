# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Development Commands

### Backend (Laravel)
- **Install dependencies**: `composer install`
- **Run development server**: `php artisan serve` (serves at http://localhost:8000)
- **Run tests**: `vendor/bin/phpunit` or `php artisan test`
- **Code formatting**: `vendor/bin/pint` (Laravel Pint for PHP code formatting)
- **Generate application key**: `php artisan key:generate`
- **Run migrations**: `php artisan migrate`
- **Clear caches**: `php artisan cache:clear`, `php artisan config:clear`, `php artisan view:clear`

### Frontend (Vite)
- **Install dependencies**: `npm install`
- **Development build with hot reload**: `npm run dev`
- **Production build**: `npm run build`

### Database
- **Run migrations**: `php artisan migrate`
- **Rollback migrations**: `php artisan migrate:rollback`
- **Seed database**: `php artisan db:seed`
- **Fresh migration with seeding**: `php artisan migrate:fresh --seed`

## Architecture Overview

This is a **Laravel 10** application with a traditional MVC architecture and modern frontend tooling.

### Key Components

- **Framework**: Laravel 10.x with PHP 8.1+
- **Frontend**: Vite for asset compilation with Laravel Vite plugin
- **Authentication**: Laravel Sanctum for API authentication
- **Database**: MySQL (configurable via .env)
- **Testing**: PHPUnit with Feature and Unit test suites

### Directory Structure

- `app/` - Core application code (Models, Controllers, Middleware, Providers)
- `routes/` - Route definitions (web.php for web routes, api.php for API routes)
- `resources/` - Views, CSS, and JavaScript assets
- `database/` - Migrations, factories, and seeders
- `tests/` - PHPUnit tests (Feature/ and Unit/ directories)
- `config/` - Configuration files
- `storage/` - File storage and logs
- `public/` - Web server document root

### Key Files

- `composer.json` - PHP dependencies and autoloading
- `package.json` - Node.js dependencies for frontend tooling
- `vite.config.js` - Vite configuration for asset compilation
- `phpunit.xml` - PHPUnit testing configuration
- `.env.example` - Environment variables template

## Environment Setup

1. Copy `.env.example` to `.env` and configure:
   - `APP_KEY` - Generate with `php artisan key:generate`
   - Database settings (DB_*)
   - Application URL and debug settings

2. Install dependencies:
   ```bash
   composer install
   npm install
   ```

3. Set up database and run migrations:
   ```bash
   php artisan migrate
   ```

## Testing

- **Run all tests**: `vendor/bin/phpunit`
- **Run specific test suite**: `vendor/bin/phpunit --testsuite=Feature` or `--testsuite=Unit`
- **Run single test file**: `vendor/bin/phpunit tests/Feature/ExampleTest.php`
- Tests use array-based drivers for caching/sessions and have database connection configurable

## API Routes

- API routes are defined in `routes/api.php`
- Protected by Sanctum authentication middleware where needed
- Default API prefix: `/api/`

## Asset Compilation

- Frontend assets are managed by Vite with Laravel integration
- Source files: `resources/css/app.css`, `resources/js/app.js`
- Hot module replacement available in development mode
- Use `@vite` directive in Blade templates to include compiled assets