# apily-rest
Permite crear un api rest mapeando las clases del ORM de Laravel.

# Configuración
Agregar la siguiente linea en config/app.php

`ApilyRest\ApilyRestProvider::class,`

Tambien en el archivo routes/web.php

`use ApilyRest\Facade\ApilyRest;`

`ApilyRest::routes();`

Publicar archivo de configuración:

`php artisan publish`