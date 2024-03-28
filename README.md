## About Exam Portal

Exam Portal is a web application framework with expressive, elegant syntax that generated and manges the questionnarie to be sent to students. It is built on Laravel as the backend framework and React JS as the frontend with Interia JS

## Prerequisites:

-   PHP >= 8.3.4
-   Composer package manager
-   Node >= 21.7.1

## Installation and Step To Run The Project

-   Clone this repository
-   Navigate to the project directory
-   Composer install
-   Npm install & npm run dev
-   Generate application key (php artisan key:generate)
-   Create a .env file:
    ( Copy .env.example to .env.
    Update environment variables in .env with your database credentials, mail configuration, etc. (refer to Laravel documentation for specific variables).)
-   Migrate the tables (php artisan migrate)
-   Seed database (Admin, Student and Questions Seeder) (php artisan db:seed)

## Run queue worker:

For sending the invitation to the student queues has been used for background jobs (like email dispatching), start the queue worker in a separate terminal:

-   php artisan queue:work

    Ensure the queue driver (e.g., database) is configured in your .env file.

## Unit Testing

This project embraces unit testing for code quality assurance. Unit tests help verify the functionality of individual application components. To run unit tests:
php artisan test

## Mail

For the developement process mailtrap has been used for checking the mail functionaltiy.
Configure the mail credentails for mailing functionality
