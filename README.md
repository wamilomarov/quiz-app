Application is build using Laravel, VueJS, Inertia.

Admin panel is built using an external package to make it easier, reliable and faster to develop.

Steps to install after cloning:

 - composer install
 - php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"
 - php artisan admin:install
 - php artisan db:seed (OPTIONAL to seed database with dummy questions and quiz histories)
 - php artisan admin:generate-menu
 - npm install
 - npx mix
 - php artisan serve

And the app will be up and running on http://127.0.0.1:8000
To see admin panel, please go to http://127.0.0.1:8000/admin using following credentials:
  - username: admin
  - password: admin

