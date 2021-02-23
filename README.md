## lara_todo
lara_todo is a simple app for keeping track of todo lists and tasks created by multiple users.

## Deployed version on Heroku
http://todo-lara.herokuapp.com/

## For local use
* Clone repository
* Create .env file use .env.example for your reference
* Set environment variables (APP_KEY variable is going to be generated with `php artisan key:generate` command)
* Install composer if needed
* Run commands in your terminal:
    - `composer install`
    - `npm install`
    - `npm run dev`
    - `php artisan key:generate`
    - `php artisan migrate`
    - `php artisan db:seed`
    - `php artisan serve`
* Access application on your development server http://127.0.0.1:8000 

---------------
Created with Laravel framework.
