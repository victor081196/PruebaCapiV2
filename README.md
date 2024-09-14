# Prueba
# Autor: Victor Manuel Anzures Tapia

Este proyecto incluye ENDPOINTS construidas con Laravel y una aplicación frontend desarrollada en Angular. A continuación, se describen los pasos para configurar y ejecutar ambos componentes.

## Estructura del Proyecto

- `api/` - Contiene el proyecto Laravel (Backend API).
- `app/` - Contiene el proyecto Angular (Frontend).

## Requisitos

Asegúrate de tener instaladas las siguientes herramientas:

- [PHP](https://www.php.net/) (para Laravel)
- [Composer](https://getcomposer.org/) (para gestionar dependencias de Laravel)
- [Node.js](https://nodejs.org/) (para Angular)
- [Angular CLI](https://angular.io/cli) (para ejecutar el proyecto Angular)

## Configuración del Backend (Laravel)

1.- **Instala las dependencias de Laravel**:

   Navega a la carpeta `api` y ejecuta:

   `cd api`.
   `
   composer install
   `.
2.- **Copia el archivo .env.example a .env y configura las variables de entorno necesarias, como la conexión a la base de datos**:
   `
   cp .env.example .env
   `
3.- **Genera la clave de la aplicación**:
   `
   php artisan key:generate
   `
4.- **Migra la base de datos**:
   `
   php artisan migrate
   `
5.- **Ejecuta los seeders para la insercion de datos si asi lo deseas**:
   `
   php artisan db:seed
   `
6.- **Inicia el servidor de desarrollo de Laravel**:
   `
   php artisan serve
   `

## Configuración del Frontend (Angular)

1.- **Instala las dependencias de Angular**:
  `
  cd app
  `
  `npm install`
2.- **Inicia el servidor de desarrollo de Angular**:
  `
  ng serve --open
  `
