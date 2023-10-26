# Frontend
# book-store

## Project Tech Stack 
- For Frontend I have used vue3 framework. 
- I have used mdb-vue-ui-kit package for UI design and components, which is based on Bootstrap 5. 
- I have used axios to make API calls. 

## Project Flow 
- On Base route I have listed all books, along with pagination and search functionality which is based on Meilisearch. 
- I have added one nav bar from there Admin user can navigate to login page
- Once Admin logged in they can access listing and add new book page 
- From listing page Admin can edit and delete existing books
- From add new book Admin can add new books 

## Project setup

npm install


### Compiles and hot-reloads for development

npm run serve


### Compiles and minifies for production

npm run build


### Lints and fixes files

npm run lint


### Customize configuration
See [Configuration Reference](https://cli.vuejs.org/config/).


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

