## About
    It's a automated email sending application connected to GMail API.

## Technology Used
    - PHP 8.1
    - Laravel framework 9

## Project Installation
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
    - env: Environment configuration


#Modules

## Domain
- This module use to manage domain. It allows to add/edit/delete the domain.
- Before adding the domain, it must be enabled GMail API. Please follow below steps to enable GMail API.

### Enable GMail API for the domain:
Any application that calls GMail APIs needs to be enabled in the API Console.

To enable an API for the domain:

- [Open the API Library](https://console.cloud.google.com/apis/library) in the Google API Console.
- If prompted, select a project, or create a new one.
- The API Library lists all available APIs. Search the GMail API to find it.
- Select the GMail API, then click the Enable button.
- If prompted, read and accept the API's Terms of Service.

### Create authorization credentials:
Any application that uses OAuth 2.0 to access GMail API must have authorization credentials that identify the application to Google's OAuth 2.0 server. The following steps explain how to create credentials for the domain. Then add the credentials(Client ID & Client Secret) below to access API for sending email, bounce tracking for the domain.

- To create an OAuth client ID, you must first configure your consent screen. Please follow below steps to configure it:

    - Go to the [OAuth consent screen](https://console.cloud.google.com/apis/credentials/consent).
    - Internal User Type.
    - Click Create.
    - Fill in the form and click Save and continue.
    - Click to Add or remove scopes button.
    - Select this scope: https://mail.google.com/ then click Save and continue.
- Then go to the [Credentials page](https://console.developers.google.com/apis/credentials).
- Click Create credentials > OAuth client ID.
- Select the Web application application type.
- Fill in the form and click Create. Specify the below authorized redirect URIs. The redirect URIs are the endpoints to which the OAuth 2.0 server can send responses.

    http://127.0.0.1:8000/mail/connection
    
    http://127.0.0.1:8000/mail/reConnect

- You're done!

