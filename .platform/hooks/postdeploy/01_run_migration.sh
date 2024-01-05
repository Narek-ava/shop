#!/bin/bash
      cd /var/app/current
      sudo chmod -R 777 storage/
      sudo chmod -R 776 bootstrap/
      php artisan migrate --force
#      php artisan db:seed --force
      php artisan config:clear
      php artisan view:clear
      php artisan passport:keys
