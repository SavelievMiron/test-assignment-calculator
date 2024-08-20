# Commission Task

Requirements:
PHP 7.4

## Installation
1. Create `.env` from `env.example`
```
cp env.example .env
```

2. Initialize the app in Docker
```php
docker-compose up --build -d
```

3. Connect to PHP CLI in Docker
```php
docker-compose run --rm php-cli sh
```

4. Install Composer dependencies
```php
composer install
```

## Commands

Run the application
```php
php main.php
```

Run tests
```php
composer run-script phpunit
```

## Info
The file with transactions is stored in `storage/files/transactions.csv`

The currency rates from [exchangeratesapi.io](https://exchangeratesapi.io) are cached in `storage/files/rates.json`

The application is extensible. A client can add a new currency, rate source, and a new strategy for commission calculation.

There is one automation test for the application which takes test input.csv, process the data, and compares actual output with an expected.
