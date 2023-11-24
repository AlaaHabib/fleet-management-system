# Fleet Management System 

## Technology Stack
- Language: PHP 8.1
- Frameworks: Laravel 10
- DB: mysql
- Authentication: Sanctum
  
## Prerequisites
Ensure the following are installed on your system:

- PHP 8
- Composer

## Packages

- spatie/laravel-permission: Handles user roles and permissions.
- darkaonline/l5-swagger: Generates Swagger documentation for the API.
- prettus/l5-repository: Simplifies the data access layer.
  
## Getting Started

- Clone the repo ```https://github.com/AlaaHabib/fleet-management-system.git```
- ```cd fleet-management-system```
- Install composer packages ```composer install```
- copy .env.copy to .env ```cp .env.copy .env```
- Add database creditionals in .env
- ``` php artisan key:generate ```
- Create schema for mysql database with same name in .env 
- ```php artisan migrate:fresh --seed```  
- ```php artisan l5-swagger:generate```
- ```php artisan serve```

### Getting Started

* Base URL:This application is hosted locally at `http://localhost:8000/`.
* Swagger URL:Swagger doc is hosted locally at `http://localhost:8000/api/documentation`.
* Postman collection in project if you want use it

  
* Feel free to explore the API endpoints and use the Swagger documentation for reference or use Postman collection in project .


