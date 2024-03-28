## Installation

composer install
php artisan migrate
php artisan db seed
php artisan storage:link

compte administrateur: 
    login: admin
    password: dcfvgbhn

authentification avec sanctum

la route /api/auth renvoi un token a renseigner dans le header Authorization
Exemple: Authorization   Bearer 8|TOxvWfOOGKmHLrjPocj9mfQ9BweMOMYEaXe5aPkw91346746