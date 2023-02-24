<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Web Shop Api Project

This is a Simple web shop project which import the user, products and create a cart for the user and place order.

Below are the step to download this project

- Clone your project

- Go to the folder application using cd command on your cmd or terminal

- Run composer install on your cmd or terminal

- Copy .env.example file to .env on the root folder. You can type copy .env.example .env if using command prompt Windows or cp .env.example .env if using terminal, Ubuntu

- Open your .env file and change the database name (DB_DATABASE) to whatever you have, username (DB_USERNAME) and password (DB_PASSWORD) field correspond to your configuration.

- Run php artisan key:generate

- Run php artisan migrate

- Run php artisan serve

- Now open postman(https://www.postman.com/downloads/) to test the API.

# Please check the Api created in the Project listed Below.
### Also prrject main directory contain a passport exported json file which you can import to get all the route and filled data.
#### All Routes apart from login and registration are protected.
 

## Register Users  
- POST 
- http://127.0.0.1:8000/api/register
 

 
## Login Users 
- Post
- http://127.0.0.1:8000/api/login
 


## Import Customers/Users 
- GET 
- http://127.0.0.1:8000/api/import-customers



## Import Products
- GET 
- http://127.0.0.1:8000/api/import-products



## Get Products
- GET 
- http://127.0.0.1:8000/api/get-products



## Add To Cart
- POST 
- http://127.0.0.1:8000/api/add-to-cart/?product_id=1



## Update Cart
- POST 
- http://127.0.0.1:8000/api/update-cart/?product_id=1&quantity=2



## Delete Cart
- POST 
- http://127.0.0.1:8000/api/delete-cart/?product_id=1



## Get Cart Data
- POST 
- http://127.0.0.1:8000/api/get-cart-data


## Place Order
- POST 
- http://127.0.0.1:8000/api/place-order


## Get All Order Data
- POST 
- http://127.0.0.1:8000/api/get-order-data


## Logout
- POST 
- http://127.0.0.1:8000/api/logout






 
