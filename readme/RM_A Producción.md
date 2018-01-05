PROYECTO A PRODUCCIÓN
=====================

* Busco [Hostinger gratis](https://www.hostinger.es/hosting-gratuito) en Google.
* Doy alta en el servicio.
* Verificamos cuenta mediante email de [000WebHost](https://es.000webhost.com/)
* Accedemos a al cuenta de [000WebHost](https://es.000webhost.com/) y seleccionamos la opción de **subir sitio propio**.

Cambios para Producción
-----------------------
1. Eliminamos el contenido de:
    * `\var\cache\`
    * `\var\logs\`
    * `\var\sessions\`
    * `\var\bootstrap.php.cache`

2. Cargamos la base de Datos en el servidor, y modificamos los parámetros de acceso de la app dentro de `\app\config\parameters.yml`. No olvidando los datos de acceso importantes como son el **database_host: localhost**, el **database_name**, el **database_user** y el **database_password**.

3. Si usamos dentro de alguna vista dentro de la aplicación la función de **Twig** '{{dump(...)}}', tendremos que modificar en `app\config\config.yml` el siguiente fragmento de código:
```yml
twig:
#    debug: '%kernel.debug%'
# usamos esta opción para usar debug en twig en el entorno de producción.
    debug:  true
```
Para usar dicha función sólo en desarrollo, usaremos el siguiente condicional:
```html.Twig
{% if app.environment == 'dev' %}
    {‌{ dump(...) }}
{% endif %}
```
