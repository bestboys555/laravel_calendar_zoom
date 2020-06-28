<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework" target="_blank"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework" target="_blank"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework" target="_blank"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework" target="_blank"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Laravel package for Zoom API
<a href="https://github.com/MacsiDigital/laravel-zoom" target="_blank">https://github.com/MacsiDigital/laravel-zoom</a>
[![Latest Version on Packagist](https://img.shields.io/packagist/v/macsidigital/laravel-zoom.svg?style=flat-square)](https://packagist.org/packages/macsidigital/laravel-zoom)
[![Build Status](https://img.shields.io/travis/macsidigital/laravel-zoom/master.svg?style=flat-square)](https://travis-ci.org/MacsiDigital/laravel-zoom)
[![StyleCI](https://github.styleci.io/repos/193588988/shield?branch=master)](https://github.styleci.io/repos/193588988)
[![Total Downloads](https://img.shields.io/packagist/dt/macsidigital/laravel-zoom.svg?style=flat-square)](https://packagist.org/packages/macsidigital/laravel-zoom)

## Install Project

Rename .env.example to .env

`cp .env.example .env`

config Mysql connection to your connection database

`composer install`

`php artisan migrate`

`php artisan db:seed --class=PermissionTableSeeder`
`php artisan db:seed --class=CreateAdminUserSeeder`
`php artisan db:seed --class=GeneralSettingsTableSeeder`

`php artisan storage:link`

##Fix code
config .env APP_URL=...  change it to real URL of your app 

on
`vendor\macsidigital\laravel-api-client\src\Support\Builder.php`
change 
`throw new HttpException($response->status(), $this->prepareHttpErrorMessage($response));`
to 
`return false;`

`php artisan key:generate`

http://127.0.0.1:8000/login
user:admin@gmail.com
pass:123456

## Create and Config Zoom api
<a href="https://marketplace.zoom.us/docs/guides/build/jwt-app" target="_blank">https://marketplace.zoom.us/docs/guides/build/jwt-app</a>

After complete create JWT App
<p align="center"><img src="https://raw.githubusercontent.com/bestboys555/laravel_calendar_zoom/master/public/images/exe/jwt.png" width="800"></p>
put Api key and Api secret to your app config
<p align="center"><img src="https://raw.githubusercontent.com/bestboys555/laravel_calendar_zoom/master/public/images/exe/6.jpg" width="800"></p>

## Project preview image
<p align="center"><img src="https://raw.githubusercontent.com/bestboys555/laravel_calendar_zoom/master/public/images/exe/1.jpg" width="800"></p>
<p align="center"><img src="https://raw.githubusercontent.com/bestboys555/laravel_calendar_zoom/master/public/images/exe/2.jpg" width="800"></p>
<p align="center"><img src="https://raw.githubusercontent.com/bestboys555/laravel_calendar_zoom/master/public/images/exe/3.jpg" width="800"></p>
<p align="center"><img src="https://raw.githubusercontent.com/bestboys555/laravel_calendar_zoom/master/public/images/exe/4.jpg" width="800"></p>
<p align="center"><img src="https://raw.githubusercontent.com/bestboys555/laravel_calendar_zoom/master/public/images/exe/5.jpg" width="800"></p>
<p align="center"><img src="https://raw.githubusercontent.com/bestboys555/laravel_calendar_zoom/master/public/images/exe/6.jpg" width="800"></p>
