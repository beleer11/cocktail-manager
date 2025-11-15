# Prueba Técnica -- Laravel + Consumo de API (TheCocktailDB)

Desarrollador: Brahiam Musse\
Stack: Laravel 11, Blade, Bootstrap, jQuery, SweetAlert2, DataTables

## 🧪 Descripción General

Este proyecto consiste en un módulo de autenticación y gestión de
cócteles.\
Incluye:

-   Login/registro utilizando Laravel Breeze\
-   Consumo de la API pública TheCocktailDB\
-   Vista para listar los cócteles obtenidos desde la API\
-   Opción de almacenar cócteles en base de datos\
-   CRUD completo de cócteles guardados\
-   Listado administrativo usando DataTables\
-   Interacciones dinámicas con jQuery + AJAX\
-   Alertas con SweetAlert2

## 🚀 Requisitos

-   PHP 8.2+
-   Composer
-   MySQL o MariaDB
-   Node.js + npm

## 📂 Instalación

### 1. Clonar repositorio

git clone https://github.com/beleer11/cocktail-manager.git
cd cocktail-manager

### 2. Instalar dependencias backend

composer install

### 3. Instalar dependencias frontend

npm install\
npm run build

### 4. Configurar .env

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5032
DB_DATABASE=cocktailmanagerdb
DB_USERNAME=root
DB_PASSWORD=123456

### 5. Generar key

php artisan key:generate

### 6. Migraciones

php artisan migrate

### 7. Instalar Breeze

composer require laravel/breeze --dev\
php artisan breeze:install\
npm install\
npm run build

## 📌 Funcionalidades

### 1. Autenticación

Basada en Laravel Breeze.

### 2. Consumo API externa

GET /cocktails/api\
Obtiene cócteles desde TheCocktailDB.

### 3. Guardar cócteles

POST /cocktails/store\
Guarda cócteles en BD vía AJAX.

### 4. CRUD de cócteles almacenados

GET /cocktails/stored\
Edición, eliminación y listado administrativo.

## 🔧 Endpoints

Método Ruta Descripción

---

GET /cocktails/api Lista desde TheCocktailDB
POST /cocktails/store Guardar vía AJAX
GET /cocktails/stored Mostrar almacenados
GET /cocktails/{id}/edit Editar
PUT /cocktails/{id} Actualizar
DELETE /cocktails/{id} Eliminar vía AJAX

## ✔️ Ejecutar el proyecto

php artisan serve\
http://127.0.0.1:8000
