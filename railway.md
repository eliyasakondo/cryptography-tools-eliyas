# Railway Deployment

This Laravel application is configured for deployment on Railway.

## Deployment Steps

1. Push this repository to GitHub
2. Connect Railway to your GitHub repository
3. Set environment variables in Railway dashboard
4. Deploy automatically

## Environment Variables Required

- `APP_KEY` (generate with `php artisan key:generate --show`)
- `APP_ENV=production`
- `APP_DEBUG=false`
- `DB_CONNECTION=mysql` (or postgresql)

## Build Command
```
php artisan migrate --force
```

## Start Command
```
php artisan serve --host=0.0.0.0 --port=$PORT
```