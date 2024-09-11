## Pizzas Project
Se administra la creación de un catálogo de Pizzas e Ingredientes donde el cálculo del precio se base en el total del precio de los ingredientes utilizados mas un 50% mas. 


## Project description:
Se usan 3 contenedores docker: Apache2, Mysql y Redis   
Se desarrollaron  2 paquetes laravel aplicando arquitectura hexagonal y DDD
Se usa REDIS para que el listado de pizzas sea presentado mas rápidamente
Se aplicaron los tests automáticos respectivos en cada paquete
Se usó Bootstrap y Jquery en el frontend, atendiendo el requisito de una página responsive
Se efectuan las validaciones respectivas en cada formulario para no tener redundancia de datos


## Developed packages:

- laravel-users: Paquete desarrollado para registrar datos de nuevos usuarios, para hacer login y crear nuevos usuarios. Tiene tests implementados
- laravel-pizzas: Paquete que administra el catálogo de pizzas

## Environment variables:
SERVER_FQDN="http://localhost"  
INCREMENT_PERCENT=50

## Steps to configure project:
Ejecutar los siguientes comandos desde la consola:  
1.- composer install  
2.- cp .env.example .env  
3.- php artisan sail:install (Seleccionar MYSQL Y REDIS)   
4.- sail up  
5.- sail artisan key:generate  
6.- sail artisan migrate 
7.- sail artisan db:seed --class="Arneon\LaravelPizzas\Infrastructure\Database\Seeders\IngredientSeeder"     
8.- sail artisan db:seed --class="Arneon\LaravelUsers\Infrastructure\Database\Seeders\UserSeeder"  
9.- sail artisan vendor:publish --tag=tests --force  

Desde un navegador, abrir el siguiente enlace:  
http://localhost (Colocar email => test@casfid.com y password => 12345678)  

## Colección Postman:  
En la carpeta tests está una colección postman para registrar usuarios y acceder al enpoint que lista las pizzas. Para usarlo debe ejecutarlos en este orden:  
1.- Endpoint user-register: Crea un nuevo usuario y copia el token en una variable de la colección.  
2.- Endpoint PizzaList: Lista las pizzas y sus respectivos ingredientes.    

## Tests automáticos:   
Los tests automáticos se ejecutan en una base de datos SQLITE y en REDIS.  
sail artisan test   
