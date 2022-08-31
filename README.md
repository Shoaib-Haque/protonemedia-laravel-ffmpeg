# protonemedia-laravel-ffmpeg
## How to clone
1. git clone https://github.com/Shoaib2018/protonemedia-laravel-ffmpeg.git
2. go inside project and run</br>
    composer install</br>
    php artisan key:generate</br>
    composer require pbmedia/laravel-ffmpeg</br>
    php artisan serve</br>

## From scratch
1. create a new laravel project</br>
    composer create-project laravel/laravel video-compress
2. go inside project and run</br>
    php artisan key:generate</br>
    composer require pbmedia/laravel-ffmpeg
3. change config/filesystems.php
4. add .gitignore inside public folder</br>
    /temp</br>
    /uploads</br>
4. create route, view, controller

