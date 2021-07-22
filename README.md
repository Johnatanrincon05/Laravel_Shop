# Shop with placetopay redirect webcheckout!
This is a store to pay with WebCheckout!

##Steps to follow for the installation and use of the solution

Requirements:

-Have the composer package manager installed
-Have the php soap extension enabled on the local server.
-Have npm installed.
-Have a Mysql database manager.

Steps to follow to start the project

1. Clone the project.
2. Create a local database with a database manager.
3. Create and configure the .Env file based on the .Env.Example the parameters of the previously created database connection (DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD) and the payment gateway variables ( LOGIN_PLACETOPAY, TRANKEY_PLACETOPAY, URL_PLACETOPAY).
4. Install and update the project dependencies by executing the __composer install__ command and also the __npm install__ command
5. Compile the css js files among others with the command __npm run dev__
6. Generate a new key for the project with __php artisan key: generate__.
7. Execute the migrations so that the tables are created in the DB with the command __php artisan migrate__
7. Run the Laravel server with the __php artisan serve__ command
8. Explore the solution.
