# skeleton_laravel
Skeleton system laravel

## Comandos a serem executados para a aplicação funcionar
- composer install
- cp .env.example .env
- php artisan key:generate
- php artisan vendor:publish
- php artisan storage:link
- php artisan migrate
- chown www-data.www-data -R bootstrap/ storage/

Editar o arquivo .env e setar as configurações de banco de dados.