#install 
put this in your main composer.json in your project 

``
"repositories": [
        {
            "type": "path",
            "url": "dash"
        }
    ],
``

in require section add this package name 
``
 "phpanonymous/dash":"*"
``

in your config/app.php 
add this in providers 
              App\Providers\DashServiceProvider::class ,

run php artisan dash:setup

all is done


Recommended From Author 
if you want to organize your project use this package 
https://nwidart.com/laravel-modules

Laravel Version 8.0

    nwidart/laravel-modules:^8.0 

Laravel Version 9.0

    nwidart/laravel-modules:^9.0 

 
if you want to see version with laravel visit this link https://github.com/nWidart/laravel-modules
| **Laravel**  |  **laravel-modules** |
|---|---|
| 5.4  | ^1.0  |
| 5.5  | ^2.0  |
| 5.6  | ^3.0  |
| 5.7  | ^4.0  |
| 5.8  | ^5.0  |
| 6.0  | ^6.0  |
| 7.0  | ^7.0 |
| 8.0  | ^8.0 |
| 9.0  | ^9.0 |


https://github.com/Astrotomic/laravel-translatable
composer require astrotomic/laravel-translatable

Versions
Package Laravel PHP
v11.10 - v11.10 8.* / 9.*   ^8.0
v11.6 - v11.9   5.8.* / 6.* / 7.* / 8.* >=7.2
v11.4 - v11.5   5.6.* / 5.7.* / 5.8.* / 6.* >=7.1.3
v11.0 - v11.3   5.6.* / 5.7.* / 5.8.*   >=7.1.3


after upload project in Cpanel
create project in home/username
rum in terminal
ln -s $(pwd)/dashproject/public $(pwd)/public_html
 