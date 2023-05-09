# symfony_basic_REST_API
A symfony rest api with jwt auth and CRUD feature for User Entity 

## Local server set up

### .env
Please copy .env to .env.local and update all necessary infos

Please create jwt info by running the following command:
#terminal(#prompt symfony console lexik:jwt:generate-keypair)

### Update dependancies
#terminal(#prompt composer install)

### Database
#terminal(#prompt symfony console doctrine:schema:update --force)

### run server
#terminal(#prompt symfony server:start -d)

