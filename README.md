## About Project

## commands
#### add mysql container for local environment
`cp ./docker-compose/docker-compose.override.yml.example docker-compose/docker-compose.override.yml`
#### run docker
`docker-compose -f ./docker-compose/docker-compose.yml up --build -d`
#### run deploy.sh script 
`./docker-compose/deploy.sh `
#### generate client
`docker exec shop-backend php artisan passport:client --password`
#### API keys passport
`docker exec shop-backend php artisan passport:install`
`docker exec shop-backend php artisan key:generate`
#### stop docker 1
`docker-compose -f ./docker-compose/docker-compose.yml down`
