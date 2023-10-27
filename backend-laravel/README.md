
## Backend
## Project Flow 
- On Base API I have made API for listed all books, along with pagination and search functionality which is based on Meilisearch. 
- Made admin Middleware to add,edit delete book can be done by admin
- Admin can login

## Project setup
composer install


## Database set up
php artisan serve
php artisan db:seed

## Laravel Scout and Meilisearch
composer require laravel/scout
php artisan vendor:publish --provider="Laravel\Scout\ScoutServiceProvider"
composer require meilisearch/meilisearch-php
# Install Meilisearch
curl -L https://install.meilisearch.com | sh
# Launch Meilisearch
./meilisearch

## Run the project
php artisan serve
