# Laravel API Authentication with Passport

This Laravel application uses Laravel Passport for API authentication. Below are the instructions for setting up and using the authentication system.

## Requirements

- PHP 8.1 or higher
- Composer
- MySQL/PostgreSQL
- Laravel 10.x
- Node.js & NPM

## First Time Project Setup

1. Clone the repository
```bash
git clone <your-repository-url>
cd <project-folder>
```

2. Install PHP dependencies
```bash
composer install
```

3. Install Node dependencies
```bash
npm install
```

4. Set up environment file
```bash
cp .env.example .env
```

5. Generate application key
```bash
php artisan key:generate
```

6. Configure database in `.env` file
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run database migrations and seeders
```bash
php artisan migrate --seed
```

8. Install Passport
```bash
# Install passport package (if not already in composer.json)
composer require laravel/passport

# Run passport migrations
php artisan migrate

# Install passport encryption keys and clients
php artisan passport:install
```

9. Link storage
```bash
php artisan storage:link
```

10. Clear all cache
```bash
php artisan optimize:clear
# OR run these individually:
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

11. Build assets
```bash
npm run build
# For development with HMR:
# npm run dev
```

12. Start the development server
```bash
php artisan serve
```

Your application should now be running at `http://localhost:8000`

## Maintenance Commands

Here are some useful commands for maintaining your application:

```bash
# Clear all cache and reload configurations
php artisan optimize:clear

# Recompile all classes
composer dump-autoload

# Clear composer cache
composer clear-cache

# Update composer dependencies
composer update

# Update npm packages
npm update

# Rebuild node modules (if having issues)
rm -rf node_modules
rm package-lock.json
npm install

# Reset database and run seeders
php artisan migrate:fresh --seed

# Clear and reset Passport
php artisan passport:client --purge
php artisan passport:install
```

## Passport Configuration

1. Add HasApiTokens trait to User model (`app/Models/User.php`):
```php
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // ...
}
```

2. Configure Passport in `config/auth.php`:
```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    'api' => [
        'driver' => 'passport',
        'provider' => 'users',
    ],
],
```

## API Routes

Configure your API routes in `routes/api.php`:

```php
Route::middleware('auth:api')->group(function () {
    // Your protected routes here
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});
```

## Authentication Endpoints

### Register User
```http
POST /api/register
Content-Type: application/json

{
    "name": "User Name",
    "email": "user@example.com",
    "password": "password",
    "password_confirmation": "password"
}
```

### Login
```http
POST /api/login
Content-Type: application/json

{
    "email": "user@example.com",
    "password": "password"
}
```

### Logout
```http
POST /api/logout
Authorization: Bearer {token}
```

## Using Access Tokens

After successful login, you'll receive an access token. Use this token in subsequent requests:

```http
GET /api/user
Authorization: Bearer {your-token-here}
```

## Managing Passport Clients

### Create Password Grant Client
```bash
php artisan passport:client --password
```

### Create Personal Access Client
```bash
php artisan passport:client --personal
```

### Clear All Clients
```bash
php artisan passport:client --purge
```

## Token Configuration

You can modify token lifetimes in `app/Providers/AuthServiceProvider.php`:

```php
public function boot()
{
    $this->registerPolicies();

    Passport::tokensExpireIn(now()->addDays(15));
    Passport::refreshTokensExpireIn(now()->addDays(30));
    Passport::personalAccessTokensExpireIn(now()->addMonths(6));
}
```

## Troubleshooting

If you encounter any issues, try these steps:

1. Clear all cache and recompile
```bash
php artisan optimize:clear
composer dump-autoload
```

2. Check permissions on storage and bootstrap/cache folders
```bash
chmod -R 775 storage bootstrap/cache
```

3. If database issues occur
```bash
php artisan migrate:fresh --seed
```

4. If Passport issues occur
```bash
php artisan passport:client --purge
php artisan passport:install
```

## Security

- Always use HTTPS in production
- Keep your client secrets secure
- Regularly rotate tokens
- Use appropriate token expiration times
- Validate all input data

## Contributing

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct, and the process for submitting pull requests.

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.
