# Cocker Drive (..en desarrollo !)

## Descripción.
Cocker Drive es una web dedicada a la gestion de archivos. <br><br> La finalidad de este proyecto sera tener un gestor de almacenamiento con versatilidad en cuanto al lugar fisico de almacenaje, pudiendo ser este desde *tu propio pc, un servidor linux casero, un NAS o servidores de mas potentes como AWS*. Este proyecto aporta la logica, el almacenaje fisico es elección suya. <br>

Mas adelante iré añadiendo en la documentacion (README) las diferentes configuraciones según el lugar de almacenaje fisico que quieres, actualmente solo tengo como almacenaje la propia maquina que corre el servidor.

#  !# Importante !# :

### Al estar actualmente en *desarrollo* habrá momentos en que las *clonaciones y pulls* que hagáis no os funcione el proyecto ya que lo estaré desarrollando en mis ramas locales.

#### Commit estables en la rama develop mientras no exista master. (ordenado de menos a mas actualizado)

- https://github.com/joseangelcrn/cocker-drive/tree/15a8dee9438211f6547a31f5485900b59816a9b9

<br>

Las **versiones estables** estaran en la rama **master** mergeandose como **release acompañados de numero de version**.
<hr>

# A tener en cuenta .. :

La aplicacion web contiene ciertos archivos como son el logo de la aplicacion e imagenes usadas como iconos para ciertos ficheros.

<hr>

# Prerequisitos:

- Guia oficial de instalacion de laravel: https://laravel.com/docs/7.x/installation

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

## 3. Instalar las dependencias del proyecto correspondiente a laravel/composer.

> composer install

## 4. Crea la key para el proyecto.

> php artisan key:generate

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
