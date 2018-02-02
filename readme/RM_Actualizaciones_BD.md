Actualizaciones Base de Datos
-----------------------------

A.Se va a crear una nueva entidad /tabla completa
-------------------------------------------------

* Realizamos las modificaciones de la estructura de la base de datos sobre **PHPMyAdmin**.

<table>
  <tr>
    <td>
    **IMPORTANTE** Realizamos copias de seguridad del contenido actual de la entidades ( **/src/BackenBundle/Entity/***) y doctrine ( **/src/BackenBundle/Resources/config/doctrine/***).
    </td>
  </tr>
</table>

* Ejecutamos en consola `php bin/console doctrine:mapping:import BackendBundle yml` para importar la estructura de tablas de la base y cargarlas en el bundle **BackendBundle** a sus distintos archivos **orm.yml**, en este caso dentro de **src\BackendBundle\Resources\config\doctrine\**.

* Una vez generados los archivos **orm.yml**, podremos actualizar las entidades mediante el comando consola ( primero lanzaremos `php bin/console doctrine:generate:entities` ) y posteriormente `php bin/console doctrine:generate:entities BackendBundle`.


* Si se hicieron actualizaciones básicas de las entidades ejecutaremos en `php bin/console doctrine:generate:entities BackendBundle` para actualizar las entidades generadas dentro de **BackendBundle** (necesario en cada actualización de datos de la entidad), permite crear los **setters** y **getters**.
