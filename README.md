# Crimson Circle - Catstagram REST API

## Important resources:

- Railway.app Live demo: https://crimsoncircle-restapi-production.up.railway.app/api
- Github repository: https://github.com/leonardoamx/crimsoncircle-restapi


## Setting up the project

Requirements:

- PHP 8.5 or higher
- Composer

After cloning the repository, follow these steps:

- Install dependencies:
```
composer install
```

- Create a `.env` file based on `.env.example`.
- Optionally, configure a MySQL database
- Add the connection parameters to the .env. Laravel uses a SQLite database as fallback.


## Running the development server

```
php artisan serve
```
Then open the localhost URL (by default http://localhost:8000) in your browser to see the app.


## Chech the file `api-endpoints.http` for a list of available features available
