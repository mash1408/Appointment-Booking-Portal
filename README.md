<h1 align="center"> Appointment-booking-portal </h1>

## Installation

Download Symfony form <a href="https://symfony.com/download">Here</a>

```
Delete all files in the migrations folder EXCEPT for "Version20210713175426.php"
```

```
Drop all your tables in the database()
```

```
composer install
```

```
Copy .env.example to .env
```
```
Create a database(if not created) and enter the db name in the .env file provided
```

Migrating table to database

```
symfony console doctrine:migrations:migrate
```

Seeding the Database with Admin Credentials

```
php bin/console doctrine:fixtures:load
```
Now you are good to go

```
symfony server:start
```

## Admin Credentials

Email: admin@admin.com | Password: password

