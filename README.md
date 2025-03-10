# MANAGEABLE WEBSITE LARAVEL

## Overview

- One page website, showcase style.
- Admin panel to manage the content of the website.
- Login authentication system to access the admin panel.

## Installation

**For your consideration**

Application developed using Laravel 11

Before continuing with the installation, make sure you meet the requirements stipulated in the documentation https://laravel.com/docs/11.x

### First batch of commands

```
git clone https://github.com/LuisMedina1991/manageable_website_laravel_11.git

```

#### Initial settings

Copy the ".env.example" file containing the environment variables and rename it to ".env"

Optionally change the APP_NAME and APP_URL values

Change the APP_LOCALE value if you want to use the default "en" lang (app is aimed at the Spanish-speaking market) (only "en" and "es" availables at the time)

Keep in mind that the APP_LOCALE value will have an impact on the language used on the seeded records

Optionally change the APP_TIMEZONE value

Fill in the ADMIN_NAME, ADMIN_EMAIL and ADMIN_PASSWORD values since they will be used to create the administrator account from UserSeeder.php so make sure to check the functionality of the assigned email first as this will be the one that receives emails from the website

Make sure to create a database and fill in all the values for database if you use a non-SQLite connection

Fill in or change the MAIL_* values to your chosen mailer, if you do not choose "log" make sure to check the functionality of the assigned credentials first

### Second batch of commands

```
composer install
npm install
php artisan key:generate
php artisan storage:link
php artisan migrate --seed
```

### Third batch of commands

In case you want to work with the compiled assets

```
nmp run build
php artisan serve
php artisan queue:work
```

Otherwise

```
composer run dev
```
