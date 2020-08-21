# Cocker Drive (stable version)

<p align="center">
    <img src="https://i.ibb.co/G7cBHw0/cocker-drive-icon.png" alt="Logo" width="250" height="250">
</p>


## Description.
Cocker Drive is a file manager web. <br><br> Purpose of this project is to have a versatile file manager in terms of phisic storage place, could be *your own pc, a home server, NAS or servers more powerfull like AWS*. This project contribute the  programming logic, physical storage place is your choise.

Later I will add in the documentation (README) the different configurations according to the physical storage place you can use, currently I have only written localhost storage system way.

# To consider .. :

This web aplication contains  uploaded files such as icon of web, images as icons of different types of files

<hr>

# php.ini file configuration server  *( example configuration, feel free to adjust it to your needs)*

> post_max_size = 2048M <br>
upload_max_filesize = 2048M  <br>
max_execution_time = 5000  <br>
max_input_time = 5000  <br>
memory_limit = 2048M  <br>
max_file_uploads= 500 <br>

<hr>

# Prerequisites:

- Official guide of laravel installation: https://laravel.com/docs/7.x/installation

<hr>

# After cloning do this:

## 1. Access to root dir of project.

> cd cocker-drive

## 2. Create .ENV file.

> cp .env.example .env

###  2.1 Configuration for localhost (XAMP,WAMP,..).

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

<hr>

# Release 0.1.0

 - **Link**: https://github.com/joseangelcrn/cocker-drive/releases/tag/0.1.0

 
 # Release 0.1.1
 
 - **Link**: https://github.com/joseangelcrn/cocker-drive/releases/tag/0.1.1
 
 # Release 0.2.0
 
 - **Link**: https://github.com/joseangelcrn/cocker-drive/releases/tag/0.2.0
 
 # Release 0.3.0
 
 - **Link**: https://github.com/joseangelcrn/cocker-drive/releases/tag/0.3.0
 

# Future thoughts

### Visual 

- Labeling system for each file. (like twitter)
- Temporal urls for sharing and another uses.

### About code

+ Fichero Class will be splited in two files:
  - FileBinManager: Refering to bin part of files (Uploading, deleting, etc..).
  - FileDataManager: Refering to storaged data on database about file information (Extension, created_at, real_name, hash_name,etc..).

Those changes will produce an improving of code reading and comprehension
