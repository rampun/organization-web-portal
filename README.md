# Web Portal App

A simple web portal app for organzation built with Laravel 8.83.27. The app contains the following features;

- Manage Members
- Mange Events
- Manage Activities
- Manage Notices
- Manage Department
- Manage Downloads/Resources
- View Suggestion from Members

API endpoints

REQUIRES AUTH:
- GET: URL/api/members - Get all memebrs
- GET: URL/api/member/{id} - Get single member
- POST: URL/api/member/search - Search member
- POST: URL/suggestion/create - Create suggestion

DONOT REQUIRE AUTH:
- GET: URL/api/activities - Get all activities
- GET: URL/api/activity/{id} - Get single activity

- GET: URL/api/events - Get all events
- GET: URL/api/event/{id} - Get single event

- GET: URL/api/downloads - Get all downloads
- GET: URL/api/download/{id} - Get single download

- GET: URL/api/notices - Get all notices
- GET: URL/api/notice/{id} - Get single notice

- GET: URL/api/departments - Get all departments

## Installation Guide

```bash
git clone git@github.com:rampun/organization-web-portal.git

cd project_name
```

In the project directory, configure the .env file. After doing so, please follow the steps below to setup the project;


```bash
# install the dependencies
composer install

# generate the vendor folder
composer dump-autoload

# run webpack in development mode
npm run dev

# migrate the database tables
php artisan migrate

# start the server locally
php artisan serve
```


#### The admin routes can be found in `routes/web.php` file
#### The API routes can be found in `routes/api.php` file
