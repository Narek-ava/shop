#!/bin/bash

# stop docker
cd ./docker-compose && docker-compose down && cd ../

# Pull from master
git pull origin master

# start docker
cd ./docker-compose && docker-compose up --build -d && cd ../

sleep 10 #todo when db is ready then run deploy script
#run deploy
cd ./docker-compose && ./deploy.sh && cd ../

docker builder prune --filter "until=10m" -f
