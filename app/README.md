# symfony_basic_REST_API
A symfony rest api with jwt auth and CRUD feature for User Entity 

# server set up

## update dependancies
composer install
composer update

## .env
Please copy .env to .env.local and update all necessary infos
- Please overwrite jwt info by running symfony console lexik:jwt:generate-keypair --overwrite

# database
symfony console doctrine:database:create
symfony console doctrine:schema:update --force
## run server
symfony server:start -d
