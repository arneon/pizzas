# Laravel Pizzas

## About
This package manage pizzas & ingredients, this has two CRUDs, one for pizza ingredients & other one for pizzas.
When a pizza is created or updated, an event is triggered to create or update data on REDIS database.
Pizzas & calculated prices are listed from REDIS database.

## Testing
In this package are implemented feature testing through PHPUnit
For test running you have to execute the following command from project root after project initialization
- sail artisan test

