# helpdesk

Es una webapp para administrar incidencias informáticas de puntos de venta de una empresa.

Características:

* Puedes controlador los usuarios, incidencias, artículos, proveedores, empresas de socios y sus puntos de venta.

* Puedes administrar el stock de artículos en almacén, ver en que puntos de venta está un articulo en préstamo, ver en el almacen que artículos tienes de los puntos de venta para reparación o sustitución, ver de que proveedor es.

## Front-End

* Diseño adaptable a móvil y tablet.
* Interfaz liviana y simple.
* Todo el diseño está hecho desde 0, sin Frameworks como Bootstrap, todo “hand made”.

Escritorio:

<img src="https://github.com/jonasdamher/helpdesk/blob/master/local/example.gif?raw=true" />

Móvil (experimental):

<img src="https://github.com/jonasdamher/helpdesk/blob/master/local/example-sm.gif?raw=true" />


## Back-End

Proyecto creado con la arquitectura MVC (Modelo, vista, controlador).

Lenguajes de programación, Frameworks y sus versiones:

* PHP 7.4.2
* Jquery 3.4.1

DDBB:

* La base de datos está creada en MySQL.
* Cotejamiento de tablas y DDBB: utf8mb4_general_ci.
* Tipo de motor de almacenamiento: InnoDB.
* La DDBB se compone de 22 tablas.

### Otros detalles

* Control de acceso de usuarios.
* Uso de varios modelos en un mismo controlador.
* Validación de datos.
* Gestor de peticiones con AJAX.
* Url amigables.
* Compresión de archivos con brotli.
* Se puede usar un archivo .env para agregar las credenciales a la conexión a la base de datos y para agregar otras credenciales privadas de APIkey, etc.

## Requerimientos

Recursos para el proyecto en la carpeta local:
* Base de datos en carpeta local/db
* Certificado autofirmado SSL en carpeta local/ssl

## Importante

Antes de empezar:
* Añadir certificado SSL autofirmado a tu servidor y a tu unidad certificadora de confianza.
* Añadir nombre ```helpdesk``` a tu archivo host de tu pc.
* Ir al archivo .dev-env.
* Renombrar archivo .dev-env como.env.
* Agregar tus credenciales a la base de datos para realizar la conexión.
* Agregar credenciales de google.
* Ir a la url ```https://helpdesk.dev/ ``` si tienes todo listo.
