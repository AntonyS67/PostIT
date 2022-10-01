## Clonar
Clonar proyecto con el siguiente comando:

```sh
git clone https://github.com/AntonyS67/PostIT.git
```

## Establecer configuracion archivo .env
Copiar el archivo .env.example y establecerle el nombre .env
Establecer los siguientes parametros

```sh
DB_DATABASE=nombre_bd
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=email
MAIL_PASSWORD=password_app
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="no-reply@gmail.com"
```

## Instalar librerias
Ejecutar el siguiente comando:
```sh
composer install
php artisan migrate
php artisan passport:install
```
## Ejecutar Proyecto
Ejecutar el siguiente comando
```sh
php artisan serve
```
Verificar la ejecucion del servidor en el navegador
con la siguiente direccion
```sh
127.0.0.1:8000
```
