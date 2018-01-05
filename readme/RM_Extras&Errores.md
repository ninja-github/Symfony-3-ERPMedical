EXTRAS. ERRORES.
================

**Fatal error: Class 'BackendBundle' not found in C:\wamp64\www\symfony.test\app\AppKernel.php on line 19**
-----------------------------------------------------------------------------------------------------------

Puede dar error al ejecutarlo, lanzando el siguiente mensaje: **Fatal error: Class 'BackendBundle' not found in C:\wamp64\www\symfony.test\app\AppKernel.php on line 19** (Ver hilo con solución, [aquí](https://stackoverflow.com/questions/44990181/fatal-error-class-not-found-in-appkernel-php)).

En este caso el error se encontraba dentro de **C:\wamp64\www\symfony.test\composer.json**,

Dentro de **C:\wamp64\www\symfony.test\composer.json**, buscamos:

```json
"autoload": {
        "psr-4": {
            "AppBundle\\": "src/AppBundle",
            "": "src/"
        },
        "classmap": [ "app/AppKernel.php", "app/AppCache.php" ]
    }
```

y lo sustituimos por:

```json
"autoload": {
        "psr-4": {
            "": "src/"
        },
        "classmap": [ "app/AppKernel.php", "app/AppCache.php" ]
    }
```

| MUY IMPORTANTE | ejecutar `composer dump-autoload` para ejecutar la función autoload. |
|----------------|----------------------------------------------------------------------|

**Warning rename var\cache\prod\doctrine/orm/Proxies/__CG__BackendBundleEntityAddressCcaa.php): Acceso Denegado (code: 5)**
----------------------------------------------------------------------------------------------------------------------------

**Warning rename (D:\00ProyectosWeb\ERPMedical---Symfony-3\var\cache\prod\doctrine/orm/Proxies/__CG__BackendBundleEntityAddressCcaa.php 5a1c9a454ffd8653102849, D:\00ProyectosWeb\ERPMedical---Symfony-3\var\cache\prod\doctrine/orm/Proxies/__CG__BackendBundleEntityAddressCcaa.php): Acceso Denegado  (code: 5)**

Cambiar dentro de **app\config\config.yml** el código
```yml
    orm:
        auto_generate_proxy_classes: '%kernel.debug%'
```
por:
```yml
    orm:
        auto_generate_proxy_classes: false
```
(Ver hilo con solución, en [stackoverflow.com/questions/37483604/symfony3-cache-warning-rename-after-update](https://stackoverflow.com/questions/37483604/symfony3-cache-warning-rename-after-update) y [symfony.com/doc/current/reference/configuration/doctrine.html](http://symfony.com/doc/current/reference/configuration/doctrine.html) )

**ERROR 500 al loguearse**
------------------------
<<<<<<< HEAD

No se puede usar {dump()} dentro de twig en producción


**[InvalidArgumentException] Could not find package fungio/google-calendar-bundle in any version matching your PHP version (5.5.9.0)**
--------------------------------------------------------------------------------------------------------------------------------------
```
 [InvalidArgumentException]
  Could not find package fungio/google-calendar-bundle in any version matching your PHP version (5.5.9.0)


require [--dev] [--prefer-source] [--prefer-dist] [--no-progress] [--no-suggest] [--no-update] [--no-scripts] [--update-no-dev] [--update-with-dependencies] [--ignore-platform-reqs] [--prefer-stable] [--prefer-lowest] [--sort-packages] [-o|--optimize-autoloader] [-a|--classmap-authoritative] [--apcu-autoloader] [--] [<packages>]...
```

El problema es debido a la versión de **PHP** instalada. Para solucionarlo accedemos a **composer.json** y en la línea `"config": { "platform": { "php": "5.6.0" }, "sort-packages": true },` modificamos la versión de php. 

Posteriormente ejecutamos el comando de consola `composer update`.


**cURL error 60: SSL certificate problem: unable to get local issuer certificate (see http://curl.haxx.se/libcurl/c/libcurl-errors.html)**
------------------------------------------------------------------------------------------------------------------------------------------

(ver fuente de la solución [aquí](https://stackoverflow.com/questions/38894213/symfony-3-1-installation-curl-error-60))

Será necesario instalar el certificado [https://curl.haxx.se/ca/cacert.pem](https://curl.haxx.se/ca/cacert.pem). 

Para ello descargamos [cacert.pem](https://curl.haxx.se/ca/cacert.pem) desde [https://curl.haxx.se/ca/cacert.pem](https://curl.haxx.se/ca/cacert.pem) y lo guardamos en **C:\wamp64\bin\php\php5.6.19\extras\ssl** según la versión de **PHP** que estemos utilizando.

**Nota** Para conocer que versión de **PHP** estamos usando simplemente acceder al [perfil debug de Symfony](http://127.0.0.1:8000/_profiler/a0e3ad?panel=security) y entrar en [request/response](http://127.0.0.1:8000/_profiler/a0e3ad?panel=request).

Después modificamos **php.ini** dentro de ** C:\wamp64\bin\php\php5.6.19\ ** en la línea `;curl.cainfo=` por `curl.cainfo ="C:\wamp64\bin\php\php5.6.19\extras\ssl\cacert.pem"` y reiniciamos la consola.
=======
No se puede usar {dump()} dentro de twig en producción
>>>>>>> master
