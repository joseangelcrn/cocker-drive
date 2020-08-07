# Cocker Drive (..en desarrollo !)

Cocker Drive es una web inspirada en google drive. <br>
Las **versiones estables** estaran en la rama **master** mergeandose como **release acompañados de numero de version**.

<hr>

# Despues de clonar haz esto:

## 1. Metete en el directorio raiz del proyecto.

> cd cocker-drive

## 2. Crea el archivo .ENV.

> cp .env.example .env

### 2.1 Configuración del fichero .ENV para servidor local (XAMP,WAMP,etc..).

> DB_CONNECTION=mysql <br>
DB_HOST=127.0.0.1 <br>
DB_PORT=3306 <br>
DB_DATABASE=cocker-drive (nombre de la base de datos, previamente tienes que ir y crear dicha base de datos en tu gestor de base de datos o te dará error.)<br>
DB_USERNAME=root (nombre usuario de tu base de datos local, por defecto: root) <br>
DB_PASSWORD= (password  de tu base de datos local, por defecto: vacio) <br>

## 3. Crea la key para el proyecto.

> php artisan key:generate

## 4. Instala las dependencias js.

> npm install

## 5. Ejecuta las migraciones de la base de datos.

> php artisan migrate

## 6. Crear un enlace simbolico en el directorio public de la aplicación para poder acceder al storage.

> php artisan storage:link

## 7. Ejecuta los seeders (Opcional).

> php artisan db:seed

### 7.1 Seed de usuario.

    Email: jose@gmail.com
    Contraseña: josejose 


## 8. Ejecuta el servidor de pruebas.

> php artisan serve
