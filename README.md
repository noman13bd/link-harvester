# Installation

Go the application directory `link-harvester-app` and run the following commands: 

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


### Step 7: See the browser

    URL: http://localhost:8080


