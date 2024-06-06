git clone https://github.com/fernando-fix/collab-prjBlog.git blog &&
cd blog &&
composer install &&
cp .env.example .env &&
php artisan key:generate &&
php artisan jwt:secret &&
php artisan env:update APP_NAME Blog &&
php artisan env:update APP_ENV local &&
php artisan env:update DB_DATABASE blog &&
php artisan env:update DB_USERNAME=root &&
php artisan env:update DB_PASSWORD=1234 &&
php artisan migrate &&
php artisan db:seed &&
code . &&
php artisan serve
