# agent

AI agent playground

## Development and deployment

Create an environment file and make any eventual configuration changes (e.g. change `APP_ENV` from `local` to `production` for deployment).

```
cp .env.example .env
```

Start the application and required services:

```
docker-compose up -d
```

Install dependencies:
```
docker compose exec app composer install
```

Set the application key:

```
docker compose exec app php artisan key:generate
```

Run database migrations:

```
docker compose exec app php artisan migrate
```

Restart queues:
```
docker compose exec app php artisan queue:restart
```

The application should now be up and running.


## Common commands

Restart the queue (required after code changes that affect jobs)

```
docker compose exec app php artisan queue:restart
```

Reset the database (delete tables and run migrations again)

```
docker compose exec app php artisan migrate:refresh
```

List all available commands:

```
docker compose exec app php artisan list
```

## REST API documentation

API documentation is automatically generated and published at `/docs/api`.

## Maintenance

Dependencies should be regularly updated by running:
```
composer update
yarn upgrade
```

and committing changes in `composer.json` and `yarn.json`.

## Tech stack

- PHP (php-fpm)
- Laravel framework
- MariaDB
- Nginx
