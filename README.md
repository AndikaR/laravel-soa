# laravel-soa
Laravel 5.5 repository design pattern generator with SOA(Service Oriented Arcitecture) inspired from this blog post: http://dfg.gd/blog/decoupling-your-code-in-laravel-using-repositiories-and-services.

### Installation 

Add VCS repository in your composer.json file

```
  "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/AndikaR/laravel-soa.git"
        }
  ],
  "require": {
      ...,
      "andikarus/laravel-soa": "^1.0.0"
  },
```

Run command `composer update` to get package then add following code in your `config/app.js` providers

```
  'providers' => [
    ...,
    Andikarus\SOAGenerator\SOAGeneratorServiceProvider::class
  ];
```
Run command `php artisan config:cache` followed by `php artisan vendor:publish` and select option with provider `Andikarus\SOAGenerator\SOAGeneratorServiceProvider` to get config file. Run command `php artisan config:cache` again to apply configuration for this package.

### Usage

Run command `php artisan soa:generate example -a` to generate all example module where example is your module name. If you only want to generate repositories or services, run command `php artisan soa:generate example` and you will be prompted to enter which type to generate. 

It will generate the following structure by default configuration:

```
app
└── Models
    ├── Entities
    |   └── Example.php
    ├── Repositories
    |   └── Example
    |       ├── ExampleRepository.php
    |       ├── ExampleRepositoryServiceProvider.php
    |       └── IExample.php
    └── Services
        └── Example
            ├── ExampleFacade.php
            ├── ExampleService.php
            └── ExampleServiceServiceProvider.php
```
Add the following configuration for namespace in your project composer.json if you use default `config/soagenerator.php` config
```
  "autoload": {
    ...,
    "psr-4": {
       ...,
       "Entities\\": "app/Models/Entities",
       "Repositories\\": "app/Models/Repositories",
       "Services\\": "app/Models/Services"
    }
  },
```

You can change this configuration in `config/soagenerator.php`. Please read http://dfg.gd/blog/decoupling-your-code-in-laravel-using-repositiories-and-services to use this pattern.
