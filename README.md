## ABOUT
    It's a automated email sending application connected to GMail account.

## TECHNOLOGY USED
    - PHP 8.1
    - Laravel framework 9

## Installing
    Please check the official laravel installation guide for server requirements before you start. Official documentation: https://laravel.com/docs/9.x/installation

    - Clone the repository.
        git clone https://github.com/bharatsindha/mailing-app.git
    - Switch to the repo folder
        cd mailing-app
    - Install all the dependencies using composer
        composer install
    - Copy the example env file and make the required configuration changes in the .env file
        cp .env.example .env
    - Generate a new application key
        php artisan key:generate
    - Run the database migrations (Set the database connection in .env before migrating)
        php artisan migrate
        php artisan db:seed
     - Run the command to start the app. This command generate the app URL. Copy it in the browser to run the app.
        php artisan serve
    - Installation completed!
    
## Code overview
    Dependencies
    - google/apiclient
    - nwidart/laravel-modules
    - maatwebsite/excel

    Folders
    - app: Contains all the Eloquent models & modules
    - app/Http/Middleware: Middleware for authorization and role management.
    - config - Contains all the application configuration files
    - database/factories - Contains the model factory
    - database/migrations - Contains all the database migrations
    - database/seeds - Contains the database seeder
    - app/Modules/Domain/: Domain module
    - app/Modules/Email/: Email module
    - app/Modules/User/: User module
    - app/Modules/Mail/: Draft, Mailing, Bounce track, Email report.
    
## Environment variables
    - env: Environment variables can be set in this file


