composer install;
cp .env.example .env
npm install
php artisan key:generate
php artisan migrate;
php artisan passport:install
php artisan storage:link
php artisan db:seed
npm run watch - start frontend

/admin - admin section

 php artisan lang:js resources/lang/translations.js --no-lib - generate translations.js file for vue
