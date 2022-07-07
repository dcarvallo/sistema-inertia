
### 🚧 In Construction 🚧
### This app aims to be the base of a system:

- Admin view
- Roles
- Permissions
- Assign roles to users
- Role dependent views
- Export (Excel | PDF)
- Note Calendar
- Send messages in real time
- Search functionality
- CRUD
  - Users
  - Roles
  - Company
  - Locations
  - Departments
  - Areas

----------

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)

Clone the repository

    git clone git@github.com/dcarvallo/sistema-inertia.git

Switch to the repo folder

    cd sistema-inertia

Install all the dependencies using composer and npm

    composer install
    npm install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Create a database connection

Check Redis Service is up

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate --seed

Start the local development server

    php artisan serve
    php artisan websockets:serve


You can now access the server at http://localhost:8000

**TL;DR command list**

    git clone git@github.com/dcarvallo/sistema-inertia.git
    cd sistema-inertia
    composer install
    npm install
    cp .env.example .env
    php artisan key:generate
    
**Make sure you set the correct database connection information before running the migrations**

    php artisan migrate --seed
    php artisan serve
    php artisan websockets:serve

----------

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

----------
