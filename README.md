<# MIC202650

Aplicación web full-stack con **Laravel 12** (API REST + Sanctum) como backend y **Vue 3** (Vite) como frontend, con sistema de autenticación y control de acceso basado en roles.

---

## Requisitos previos

| Herramienta | Versión mínima |
|-------------|---------------|
| PHP         | 8.2           |
| Composer    | 2.x           |
| Node.js     | 22.18 / 24.12 |
| npm         | incluido con Node |
| MySQL       | 8.x           |

---

## Clonar el repositorio

```bash
git clone <https://github.com/Matteo21ME/MIC202650_TEMPLATE.git>
cd MIC202650
```

---

## Configuración del Backend

### 1. Instalar dependencias PHP

```bash
cd backend
composer install
```

### 2. Configurar variables de entorno

```bash
cp .env.example .env
```

Edita `.env` y ajusta los datos de conexión a tu base de datos MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mic202650
DB_USERNAME=root
DB_PASSWORD=tu_password
```

### 3. Generar la clave de la aplicación

```bash
php artisan key:generate
```

### 4. Ejecutar migraciones y seeders

```bash
php artisan migrate
php artisan db:seed
```

Esto crea las tablas y los siguientes usuarios de prueba:

| Email                    | Contraseña      | Rol           |
|--------------------------|-----------------|---------------|
| admin@example.com        | admin123        | Administrador |
| dev@example.com          | dev123          | Desarrollador |
| supervisor@example.com   | supervisor123   | Supervisor    |
| user@example.com         | user123         | Usuario       |

### 5. Iniciar el servidor de desarrollo

```bash
php artisan serve
```

El backend queda disponible en `http://localhost:8000`.

---

## Configuración del Frontend

### 1. Instalar dependencias Node

```bash
cd ../frontend
npm install
```

### 2. Iniciar el servidor de desarrollo

```bash
npm run dev
```

El frontend queda disponible en `http://localhost:5173`. Las peticiones a `/api` se proxizan automáticamente al backend en `http://localhost:8000`.

---

## Ejecución simultánea (opcional)

Desde la carpeta `backend` puedes levantar todo con un solo comando:

```bash
cd backend
composer run dev
```

Esto inicia en paralelo el servidor PHP, el listener de colas y el servidor Vite.

---

## Build para producción

```bash
cd frontend
npm run build
```

Los archivos compilados se generan en `backend/public/`. Sirve la aplicación directamente desde Laravel apuntando a esa carpeta.

---

## Estructura del proyecto

```
MIC202650/
├── backend/    # Laravel 12 — API REST con Sanctum
└── frontend/   # Vue 3 + Vite — SPA
```

---

## API Endpoints principales

| Método | Endpoint         | Descripción                      | Acceso        |
|--------|------------------|----------------------------------|---------------|
| POST   | /api/auth/login  | Autenticación, retorna token     | Público       |
| POST   | /api/auth/logout | Cierra sesión (revoca token)     | Autenticado   |
| GET    | /api/auth/me     | Datos del usuario autenticado    | Autenticado   |
| GET    | /api/roles       | Lista de roles                   | Admin/Dev/Sup |
| GET    | /api/usuarios    | Lista de usuarios                | Admin/Dev/Sup |
