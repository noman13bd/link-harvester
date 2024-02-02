# Installation

Go the application directory where its cloned and run the following commands: 

### Step 1:

    $ cp ./src/.env.example ./src/.env

### Step 2:

    $ docker compose up --build -d
     
### Step 3:

    $ docker compose exec app composer install

### Step 4:

    $ docker compose exec app php artisan key:generate

### Step 5:

    $ docker compose exec app chmod -R 777 storage/ bootstrap

### Step 6:

    $ docker compose exec app php artisan migrate && docker compose exec app php artisan optimize:clear


### Step 7: browse the app

    URL: http://localhost:8080

### Output: Click to watch @ Youtube

[![Working demo of the app](https://img.youtube.com/vi/NPVlJ6r5l6c/0.jpg)](https://www.youtube.com/watch?v=NPVlJ6r5l6c)


