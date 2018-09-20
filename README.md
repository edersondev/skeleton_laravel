# skeleton_laravel
Skeleton system laravel

## Comandos e instruções a serem executados para a aplicação funcionar
- composer install
- cp .env.example .env
- php artisan key:generate
- Configure o arquivo .env para conexão com o banco de dados
- php artisan migrate
- php artisan db:seed --class=InitialDataSeeder
- php artisan vendor:publish
- php artisan storage:link
- chown www-data.www-data -R bootstrap/ storage/

## Dados para efetuar o login
email: admin@teste.com.br
senha: 123456