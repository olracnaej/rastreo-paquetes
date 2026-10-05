# Rastreo de paquetes (Laravel)

Dos páginas: **panel privado** (tú registras estados) y **página pública** (clientes pegan su tracking).
Cada guardado va a MySQL y se agrega una fila al historial en Google Sheets.

## 1. Crear el proyecto y copiar estos archivos
```bash
composer create-project laravel/laravel rastreo
cd rastreo
composer require laravel/breeze --dev
php artisan breeze:install blade      # login
```
Copia las carpetas de este zip (`app`, `config`, `database`, `resources`, `routes`) dentro del proyecto
y acepta reemplazar `routes/web.php`.

## 2. Cerrar el registro (importante)
Breeze deja que cualquiera cree una cuenta. En `routes/auth.php` borra o comenta las dos rutas de
`register` (GET y POST). Crea tu usuario una sola vez con:
```bash
php artisan tinker
>>> \App\Models\User::create(['name'=>'Tu nombre','email'=>'tu@correo.com','password'=>bcrypt('una-clave-larga')]);
```

## 3. Base de datos
En `.env` pon tu MySQL (`DB_CONNECTION=mysql`, `DB_DATABASE`, etc.) y corre:
```bash
php artisan migrate
php artisan serve
```
- Clientes: http://127.0.0.1:8000
- Tu panel: http://127.0.0.1:8000/login

## 4. Google Sheets
1. En Google Cloud crea una **cuenta de servicio**, activa **Google Sheets API** y descarga el JSON.
2. Guárdalo en `storage/app/google-service-account.json`.
3. Crea una hoja con una pestaña llamada `Historial` y compártela (Editor) con el correo de la cuenta de servicio.
4. Instala y publica el paquete:
```bash
composer require revolution/laravel-google-sheets
php artisan vendor:publish --provider="Revolution\Google\Sheets\Providers\SheetsServiceProvider"
```
5. En `.env`:
```
GOOGLE_SERVICE_ENABLED=true
GOOGLE_SERVICE_ACCOUNT_JSON_LOCATION=storage/app/google-service-account.json
GOOGLE_SHEET_ID=el-id-que-aparece-en-la-url-de-tu-hoja
GOOGLE_SHEET_NAME=Historial
```
Columnas por fila: fecha, tracking, cliente, estado, ubicación, entrega estimada, nota.
Si Sheets no está configurado o falla, el paquete igual se guarda en la base de datos.

## 5. Publicar en Railway
Sube el proyecto a GitHub, crea un proyecto en Railway con ese repo y agrega un servicio MySQL.
Define las variables de `.env` (incluye `APP_KEY`, `APP_ENV=production`, `APP_DEBUG=false`) y
corre `php artisan migrate --force`. No subas el JSON de Google al repo.

## Cambiar las etapas
Edita la lista `stages` en `config/tracking.php`.
