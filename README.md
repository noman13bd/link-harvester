# Installation

Go the application directory `link-harvester-app` and run the following commands: 

### Step 1: Copy env 

    $ cp .env.example .env

    $ docker compose exec app composer install

### Step 2: Build the container

    $ docker compose up --build -d
     
     also run the below command after build succedded

    $ docker compose exec app php artisan key:generate

### Step 3: set permission to setup

    $ docker compose exec app chmod -R 777 storage/ bootstrap

### Step 4: Install packages    

    $ docker compose exec app composer install

### Step 5: Run migration command

    $ docker compose exec app php artisan migrate && docker compose exec app php artisan optimize:clear


### Step 6: See the browser

    URL: http://localhost:8080


