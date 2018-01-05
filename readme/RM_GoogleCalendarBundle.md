GOOGLE CALENDAR BUNDLE
======================

(Ver fuente [aquí]()ttps://github.com/fungio/FungioGoogleCalendarBundle))

Este paquete usa la [**API de Google**](https://console.developers.google.com) para **listar**, **crear** o **actualizar** eventos en **Google Calendar**.

Requisitos
----------

1. Crea una cuenta API, para ello vaya a la [consola de desarrolladores](https://console.developers.google.com)
2. Crea una **oauth ID**. No olvides redirigir a Uri.

  * Para ello accedemos logueandonos con una cuenta de **Gmail** en [https://console.developers.google.com/](https://console.developers.google.com/)
  * Creamos nuestro nuevo proyecto haciendo click en:

![APIGoogleCalendar_01](https://github.com/HecFranco/ERPMedical/blob/master/readme/capture/APIGoogleCalendar_01.jpg)

  * Y seleccionando la opción de crear nuevo proyecto.

![APIGoogleCalendar_02](https://github.com/HecFranco/ERPMedical/blob/master/readme/capture/APIGoogleCalendar_02.jpg)

  * Una vez creado el nuevo proyecto para desarrollo lo seleccionamos.

![APIGoogleCalendar_03](https://github.com/HecFranco/ERPMedical/blob/master/readme/capture/APIGoogleCalendar_03.jpg)

**IMPORTANTE!!** Podemos comprobar si la **API** que queremos utilizar está habilitada accediendo a [**Biblioteca**](https://console.developers.google.com/apis/library) y buscándola.

**IMPORTANTE!!** Para añadir las credenciales, es necesario verificar la propiedad de la cuenta para ello se recomienda usar el método alternativo de registro mediante **Google Analytics**.

3. Haga clic en "Descargar JSON" para obtener su client_secret.json

Instalación
------------

** Paso 1: ** Instalar **GoogleCalendarBundle**, mediante el comando de consola `composer require fungio/google-calendar-bundle:dev-master`.

** Paso 2: ** Activar Bundle

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = [
        // ...
        new Fungio\GoogleCalendarBundle\FungioGoogleCalendarBundle()
    ];
}
```

** Paso 3: ** Configuración - Copie su archivo client_secret.json, por ejemplo, en **app/Resources/GoogleCalendarBundle/client_secret.json**.

```yml
# app/config/parameters.yml
fungio_google_calendar:
    google_calendar:
        application_name: "Google Calendar"
        credentials_path: "%kernel.root_dir%/.credentials/calendar.json"
        client_secret_path: "%kernel.root_dir%/Resources/GoogleCalendarBundle/client_secret.json"
```

=======

![APIGoogleCalendar_01](https://github.com/HecFranco/ERPMedical/blob/master/readme/capture/APIGoogleCalendar_01.jpg)

3. Haga clic en "Descargar JSON" para obtener su client_secret.json
