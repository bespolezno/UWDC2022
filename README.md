# UWDC2022

2nd unofficial Web Development Competition 2022

## Installation

1. Install composer packages
``` 
composer install
```
2. Create .env, write database credentials and generate key
``` 
php artisan key:generate
```
3. Install dependencies for frontend app
``` 
npm install
```
4. Build the app
``` 
npm run prod
```
5. Up migrations
``` 
php artisan migrate:fresh --seed
```

## Usage

Open application in browser
