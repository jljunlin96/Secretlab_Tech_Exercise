# Laravel Project Setup Guide

This guide provides a step-by-step process to set up a Laravel project on your local machine.

---

## Prerequisites

Ensure you have the following installed:

1. **PHP**: Version 8.2 or higher
2. **Composer**: Latest version
3. **Node.js**: Version 16 or higher
4. **NPM** or **Yarn**
5. **MySQL**: Version 5.7 or higher
6. **Git**: Latest version

---

## Setup Steps

### 1. Clone the Repository

```bash
git clone <repository-url>
cd <project-directory>
```

### 2. Install Dependencies

Run the following command to install PHP dependencies:

```bash
composer install
```

Install Node.js dependencies:

```bash
npm install
```

### 3. Configure Environment Variables

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Update the `.env` file with your local configuration:

- **DB_HOST**: Database host (usually `127.0.0.1`)
- **DB_PORT**: Database port (default `3306`)
- **DB_DATABASE**: Name of your database
- **DB_USERNAME**: Database username
- **DB_PASSWORD**: Database password

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Set Up the Database

Create a new database and update the `.env` file accordingly.

Run the migrations:

```bash
php artisan migrate
```

### 6. Start the Development Server

Run the Laravel development server by your preferred method:

- [Laravel Homestead (for Windows, macOS, or Linux system)](https://laravel.com/docs/11.x/homestead)
- [Laravel Valet (for macOS)](https://laravel.com/docs/11.x/valet)


## Additional Steps (Optional)

### Running Tests

Run PHPUnit tests:

```bash
php artisan test
php artisan test --coverage-html coverage-report
```

---

## Troubleshooting

- **Permission Issues**: Ensure `storage` and `bootstrap/cache` directories are writable:

```bash
chmod -R 775 storage bootstrap/cache
```

- **Missing Extensions**: Verify required PHP extensions are installed (e.g., `pdo`, `mbstring`, `openssl`, `tokenizer`).

- **Environment Issues**: Double-check the `.env` configuration.

---

## Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Composer Documentation](https://getcomposer.org/doc/)
- [Node.js Documentation](https://nodejs.org/en/docs/)

