# LaravelPartialSeeder
Only seed what you haven't seeded yet.



# About
This packages extends the seeding functionality with the addition of history control. This allows you to only run the seeders that you haven't run yet.



# Installation
Install this package with the following command:
```
composer require devmcc/laravel-partial-seeder
```


## ServiceProvider
Add the following line in `providers`, in the file `config/app.php`:
```
DevMcC\LaravelPartialSeeder\ServiceProvider::class,
```



# Commands
The following is a documentation about all available commands:


## Install

### Usage
```
php artisan prtl-seeder:install [options]
```

### Description
Creates the `partial_seeds_history` table

### Options
<sub><sup>Standard Artisan command options.</sup></sub>


## Status

### Usage
```
php artisan prtl-seeder:status [options]
```

### Description
Show the status of each partial seeder

### Options
<sub><sup>Standard Artisan command options.</sup></sub>


## Seed

### Usage
```
php artisan prtl-seeder:seed [options]
```

### Description
Seed the database with history controlled records

### Options
<sub><sup>Standard Artisan command options.</sup></sub>
#### --database[=DATABASE]
The database connection to seed
#### --force
Force the operation to run when in production


## Make

### Usage
```
php artisan make:prtl-seeder <name> [options]
```

### Description
Create a new partial seeder class

### Arguments
#### <name>
The name of the class

### Options
<sub><sup>Standard Artisan command options.</sup></sub>

### Note
#### Note #1
The created seeder is added into the `partial_seeds` directory, in the database directory (`database`).
