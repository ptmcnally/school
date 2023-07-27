# Wonde School Demo App

## Getting Started

These instructions will help you get a copy of the project up and running for development and testing purposes.

Requires: Docker, Composer.

### Running Via Docker

Check out the project & run the following commands from the project root.

`composer install`

`cp .env.example .env`

`./vendor/bin/sail up -d`

`sudo chmod -R 777 storage/`

`docker exec -it school-laravel.test-1 php artisan migrate:fresh --seed` 

`npm install`

`npm run dev`


Navigate to http://127.0.0.1/



# Testing Instructions

## Dashboard

Log in with email: "teacher@example.com" / password: "password"

Once logged in as a teacher (test account is linked to Alister Pinkey) you will be taken to the teacher's dashboard. The timetable widget should show the lessons for the current day.

If the current day has no lessons you can set the date manually in resources/js/Pages/Dashboard.vue L25 to see this widget in action.


## Timetable

From the dashboard page, you can either click the "View Full Timetable" button, or click the Timetable tab at the top-left of the screen. This will take you to the Timetable overview screen.

You can use the date selector to select the date you would like to see the lesson schedule for. Once a date is selected the page will automatically load the lessons. 2023-07-04 for example has 3 lessons for that day.   

## Class Details 

You can view the class details and students list by clicking the class link on each lesson.

To return back to the currently selected day in the timetable you can use the breadcrumbs menu.

### Unit tests

Unit tests can be run using the following command. They are run automatically on this repo using a PHPUnit workflow on push.

`./vendor/bin/phpunit`

### Notes

- This app is built using Laravel, Inertia & Vue.js with Laravel Breeze for authentication.

- With more time this could be improved with more unit / feature tests.

- Auth (sanctum) also needs configuring for API routes.
