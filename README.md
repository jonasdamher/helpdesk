<img src="https://github.com/jonasdamher/helpdesk/blob/master/public/images/logo/launcher-3.png?raw=true" align="right" width="128" />

# helpdesk

> Es una webapp para administrar incidencias informáticas de puntos de venta de una empresa.

Características:
* Puedes administrar los usuarios, incidencias, artículos, proveedores, empresas de socios y sus puntos de venta.
* Puedes controlar el stock de artículos en almacén, ver en que puntos de venta está un artículo en préstamo, ver en el almacen que artículos tienes de los puntos de venta para reparación o sustitución, ver de que proveedor es el artículo.

## Planteamiento del proyecto :page_facing_up: 

Idea principal y pasos a realizar:
* Un punto de venta necesita la reparacion de un dispositivo.
* El/La responsable de punto de venta manda un correo electrónico o llama al departamento de SAT.
* Un operario registra la incidencia en la webapp.
* Un operario con la incidencia asignada procede a ir buscar el dispositivo estropeado para dicha reparación y se sustituye el dispositivo estropeado por uno del almacén.
* Se trata de reparar el dispositivo del punto de venta.
  * Si no es posible el punto de venta se queda con el dispositivo en prestamo y el operario pide presupuesto para uno nuevo.
  * Despues el responsable del punto de venta acepta/declina el presupuesto.
  * Si se acepta se procede a comprar el dispositivo nuevo y despues a darle la factura y una copia del albarán al responsable del punto  de venta. 
  * Si el/la responsable declina el presupuesto, el punto de venta se queda el dispositivo de sustitución por el momento.
* Se finaliza la incidencia si lo requiere.

## Front-End :rainbow: 

* Diseño adaptable a móvil y tablet.
* Interfaz liviana y simple.
* Para diseñar los estilos y cada modelo adaptable usé CSS3.
* Todo el diseño está hecho desde 0, sin Frameworks como Bootstrap, todo “hand made”.

Escritorio:
<p align="center">
<img src="https://github.com/jonasdamher/helpdesk/blob/master/local/example.gif?raw=true" />
</p>

Móvil (experimental):
<p align="center">
<img src="https://github.com/jonasdamher/helpdesk/blob/master/local/example-sm.gif?raw=true" />
</p>

## Back-End :rocket: 

Proyecto creado con el estilo de arquitectura MVC (Modelo, vista, controlador), usando el paradigma OOP (Programación orientada a objetos).

Lenguajes de programación, Frameworks y sus versiones:
* PHP 7.4.2
* Jquery 3.4.1

DDBB:
* La base de datos está creada en MySQL.
* Cotejamiento de tablas y DDBB: utf8mb4_general_ci.
* Tipo de motor de almacenamiento en todas las tablas: InnoDB.
* La DDBB se compone de 22 tablas.

Esquema de relaciones:
<p align="center">
<img src="https://github.com/jonasdamher/helpdesk/blob/master/local/relations-example.png?raw=true" />
</p>

## Otros detalles :triangular_flag_on_post: 

* Tiene la configuración básica de una PWA (aplicación web progresiva) para poder tener en tu dispositivo la web con acceso directo.
* Control de acceso de usuarios.
* Posibilidad de usar de varios modelos en un mismo controlador.
* Validación y saneamiento de datos en Back-End.
* Optimización de imagenes.
* Gestor de peticiones con AJAX.
* Url amigables.
* Compresión de archivos con brotli.
* Se puede usar un archivo .env para agregar las credenciales a la conexión a la base de datos y para agregar otras credenciales privadas de APIkey, etc.

## Requerimientos :clipboard: 

Recursos para el proyecto en la carpeta local:
* Base de datos en carpeta ```local/db```.
* Certificado autofirmado SSL en carpeta ```local/ssl```.

## Importante :exclamation: 

Antes de empezar:
* Añadir certificado SSL autofirmado a tu servidor y a tu unidad certificadora de confianza.
* Añadir nombre ```helpdesk``` a tu archivo host de tu pc.
* Ir al archivo .dev-env.
* Renombrar archivo ```.dev-env``` como ```.env```.
* Agregar las credenciales a la base de datos para realizar la conexión (ya está por defecto).
* Agregar credenciales de google.
* Ir a la url ```https://helpdesk.dev/``` si tienes todo listo.
