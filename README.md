# HMPSTIUB

# Requirement
- Php Version > 8.1
- Node JS

# How To Setup
- First you need to duplicate the .env.example file after that you must rename the .env.example to .env
- Second after you rename the .env file you must configure with the database on env file like this
  - DB_CONNECTION=mysql
  - DB_HOST=127.0.0.1
  - DB_PORT=3306
  - DB_DATABASE=hmpstis // its up to you to name the database
  - DB_USERNAME=root
  - DB_PASSWORD=
- Third, you have to create a new database with a database name according to your configuration in .env file
- Fourth, you have to config ure the smtp on env like this
   - MAIL_MAILER=smtp
   - MAIL_HOST=smtp.gmail.com
   - MAIL_PORT=465
   - MAIL_USERNAME=hmpstiub@gmail.com
   - MAIL_PASSWORD=dvhgpmsmkbdweabd
   - MAIL_ENCRYPTION=tls
   - MAIL_FROM_ADDRESS="hmpstiub@gmail.com"
   - MAIL_FROM_NAME="${APP_NAME}"

- composer install
- npm install
- php artisan key:generate
- php artisan storage:link
- php artisan migrate
- php artisan db:seed

# How to run
- npm run dev
- php artisan serve

# Login
To log in, use the email and password following the seeder :
Email = hmpstiub@gmail.com
Password 12345678
