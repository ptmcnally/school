sudo chmod -R 777 storage/

composer install

./vendor/bin/sail up -d

php artisan migrate:fresh --seed

npm run dev
