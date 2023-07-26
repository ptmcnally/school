# Wonde School App

## Getting Started

These instructions will help you get a copy of the project up and running for development and testing purposes.

### Running Via Docker

Check out the project & run the following commands from the project root.

`composer install`

`./vendor/bin/sail up -d`

`sudo chmod -R 777 storage/`

`docker exec -it school-laravel.test-1 php artisan migrate:fresh --seed` 

`npm install`

`npm run dev`


Navigate to http://127.0.0.1/

Log in with "teacher@example.com" / password: "password"

### Notes

With more time this could be improved with more unit / feature tests.

Auth (sanctum) also needs configuring for API routes.

