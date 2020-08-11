# Cocker Drive (..developing.. !)

## Description.
Cocker Drive is a file manager web. <br><br> Purpose of this project is to have a versatile file manager in terms of phisic storage place, could be *your own pc, a home server, NAS or servers more powerfull like AWS*. This project contribute the  programming logic, physical storage place is your choise.

Later I will add in the documentation (README) the different configurations according to the physical storage place you can use, currently I have only written localhost storage system way.

#  !# Important !# :

### Being currently in  *development* there will be times when  you *pull or clone* you do will not work the project since I will developing in local branch develop.

#### Stables commits on develop branch while doesnt exist branch master (ordered by UPDATE ASC).

1. https://github.com/joseangelcrn/cocker-drive/tree/15a8dee9438211f6547a31f5485900b59816a9b9
    - Can upload files.
    - List your uploaded files but you cant filter it.
    
2. https://github.com/joseangelcrn/cocker-drive/tree/f0f50c529e4cdd928866ba2da6d3b716173e5827
    - CRUD file created.
    - Now you can filter your files by it filenames. (Advance Searching still doesnt work).

3. https://github.com/joseangelcrn/cocker-drive/tree/aa8abf28a92c7354764e503fc855358b14e8afe0
    - Donut chart in home view which display percent of different extensions files stored in your account.

<br>

The **stables versions** will be in  **master branch** merging as  **release [version number]**.
<hr>

# To consider .. :

This web aplication contains  uploaded files such as icon of web, images as icons of different types of files

<hr>

# Prerequisites:

- Official guide of laravel installation: https://laravel.com/docs/7.x/installation

<hr>

# After cloning do this:

## 1. Access to root dir of project.

> cd cocker-drive

## 2. Create .ENV file.

> cp .env.example .env

### 2.1 Configuration for localhost (XAMP,WAMP,..).

> DB_CONNECTION=mysql <br>
DB_HOST=127.0.0.1 <br>
DB_PORT=3306 <br>
DB_DATABASE=cocker-drive (database name, it must previously exist  or you will get error. So yout must create it in your database manager as phpmyadmin. )<br>
DB_USERNAME=root (database username, default: root) <br>
DB_PASSWORD= (password  database, default: 'empty') <br>

## 3. Install composer/laravel dependences of project.

> composer install

## 4. Create project key.

> php artisan key:generate

## 5. Run migrations.

> php artisan migrate

## 6. Create storage link for public directory.

> php artisan storage:link

## 7. Run seeders (Optional).

> php artisan db:seed

### 7.1 Info users seeds.

    Email: jose@gmail.com
    Contraseña: josejose 

## 8. Run serve.

> php artisan serve
