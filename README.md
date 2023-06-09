# PHP Laravel samples for Stimulsoft Reports.PHP

#### This repository contains the source code of the examples of usage Stimulsoft Reports.PHP reporting tool in the PHP Laravel application, using HTML/PHP code and JavaScript components. The report builder is fully compatible with Laravel 8 and higher, uses Blade templates, and a controller to handle events for embedding components.

## Overview
This repository has a standard Laravel web project with Report Viewer and Report Designer components, as well as several sample reports.

## Running samples
The folder contains all the scripts and resources of the project. So all files from this folder must be copied to your PHP server, using FTP or HTTP access interface - depending on your hosting provider.

Before copying the files, you need to create the `.env` configuration file for the Laravel application. You can copy the configuration template from the `.env.example` file, and make changes if necessary. On first launch, the Laravel application will ask you to generate a unique application key, which will be stored in the `.env` configuration file.

To download all dependencies, please use the command:  
`composer update`

To run the project, please use the command:  
`php artisan serve`

After that, the web project is available at:  
http://127.0.0.1:8000/

For more information, see the [documentation](https://laravel.com/docs) on working with Laravel framework.

## Deployment
To add Stimulsoft components to your Laravel application, just follow a few simple steps.

1. Add the Stimulsoft library dependency using the Composer manager:  
```
composer require stimulsoft/reports-php
```
  
2. Add Stimulsoft service provider to app.php file:  
```php
Stimulsoft\Laravel\StiServiceProvider::class
```
  
3. Add the Blade component template to the application resources, for example:  
```
viewer.blade.php
```
  
4. Add a component controller and set the necessary methods for event handling in it, for example:  
```
HandlerController.php
```
  
5. Add the necessary routes to the created view and controller in the web.php file, for example:
```php
Route::get('/viewer', function () {
    return view('viewer');
});

Route::any('/handler', [HandlerController::class, 'process']);
```
  
6. Everything is ready, you can launch the application and work with Stimulsoft reports.

## About Stimulsoft Reports.PHP
Stimulsoft Reports.PHP is a report generator intended to create, view, print, and export reports online using client-server technology. The Stimulsoft report generator for PHP is a fast and powerful report engine, rich and intuitive interface, simple integration and deployment process, and an easy and understandable licensing model.

## Useful links
* [Live Demo](http://demo.stimulsoft.com/#Js)
* [Product Page](https://www.stimulsoft.com/en/products/reports-php)
* [Composer Package](https://packagist.org/packages/stimulsoft/reports-php)
* [Free Download](https://www.stimulsoft.com/en/downloads)
* [Documentation](https://www.stimulsoft.com/en/documentation/online/programming-manual/reports_and_dashboards_for_php.htm)
* [License](LICENSE.md)
