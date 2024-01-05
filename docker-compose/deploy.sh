#!/bin/bash

# Install Composer dependencies
docker exec shop-backend composer install

# Run Laravel migrations
docker exec shop-backend php artisan migrate

# Seed the database (if you have seeders)
docker exec shop-backend php artisan db:seed
