# Symfony Basic REST API

This is a Symfony REST API project that provides JWT authentication and CRUD functionality for a User entity.

## Local Server Setup

To set up the local server, please follow these steps:

1. Copy the `.env` file to `.env.local` and update any necessary information.

2. Generate a JWT keypair by running the following command in the terminal from the root directory of your project:

symfony console lexik:jwt:generate-keypair

3. Install dependencies by running the following command in the terminal:

composer install

4. Update the database schema by running the following command in the terminal:

symfony console doctrine:schema:update --force

5. Start the server by running the following command in the terminal:

symfony server:start -d

Make sure to run all the commands from the root directory of your project. With these steps completed, you should have a local server set up and ready to use.
