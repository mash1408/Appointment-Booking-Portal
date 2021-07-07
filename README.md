<h1 align="center"> Appointment-booking-portal </h1>

## Installation 
Download Symfony form <a href="https://symfony.com/download">Here</a>

```
composer install
```
Copy .env.example to .env
```
copy .env.example .env
```
Create a database and enter the db name in the .env file provided
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
End
