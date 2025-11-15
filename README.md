# Prueba Técnica -- Laravel + Consumo de API (TheCocktailDB)
<img width="1892" height="994" alt="image" src="https://github.com/user-attachments/assets/84096e0a-94d8-48f4-a6d8-721f1fe166e9" />

<img width="1880" height="975" alt="image" src="https://github.com/user-attachments/assets/a76d81b0-83ed-4335-8a7b-70f9327d7297" />

<img width="1875" height="977" alt="image" src="https://github.com/user-attachments/assets/e4a41d10-8132-4dc9-9291-ab2a3b83a3ce" />

<img width="1886" height="944" alt="image" src="https://github.com/user-attachments/assets/1d878b73-ede1-49b3-af4a-6a6fd2aeb068" />

<img width="1902" height="998" alt="image" src="https://github.com/user-attachments/assets/0e5b608e-ecc6-4322-8cd7-d1956f6ee6ee" />

<img width="1905" height="999" alt="image" src="https://github.com/user-attachments/assets/eed301f5-b7c6-4e97-848d-dca07622d71f" />

<img width="1916" height="985" alt="image" src="https://github.com/user-attachments/assets/409646f7-b34b-4526-a366-4582c560575e" />

<img width="1903" height="992" alt="image" src="https://github.com/user-attachments/assets/b3b714b0-2b35-480f-a8b3-a3cf86d3dc0c" />

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
