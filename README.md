# Wikiprecios
Aplicación desarrollada en la materia de Desarrollo de Software en la UNPSJB.

## Preparación
Requisitos previos:

Instalar Node.js y NPM:
* `sudo apt-get install -g npm`
* `sudo apt-get install node`

Instalar Bower:
* `sudo npm install -g bower`

Instalar Grunt:
* `sudo npm install -g grunt-cli`

Tener instalado XAMPP o LAMPP:
* Ver la configuracion de la base de datos en `application/config/database.php`.
* Se debe tener creada la base de datos `wikiprecios` antes de comenzar.

## Despliegue

1. Clonar el repositorio: `https://github.com/emanuelbalcazar/wikiprecios`.
2. Colocar el proyecto en la carpeta `htdocs` del xampp o lampp.
3. Ejecutar en el directorio raiz del proyecto `npm install` y `bower install` (puede utilizar grunt, ver mas abajo).
4. Migrar las tablas de la base de datos con: `grunt migrate`.
5. Migrar los datos iniciales con : `grunt seed`.
6. Ejecutar `grunt devel` o `grunt prod` (ver la descripción mas abajo).
7. Acceder a la aplicacion web en `http://localhost/wikiprecios/`.


## Nota

Ver que el archivo `Gruntfile.js` en la raiz del proyecto incluye las siguientes tareas:

* `grunt install` - ejecuta npm install y bower install en secuencia.
* `grunt migrate` - ejecuta las migraciones creando las tablas en la base de datos.
* `grunt seed` - ejecuta el seeder migrando los datos de `application/controllers/seeds/files/*.csv`.
* `grunt test` - ejecuta jshint revisando la calidad del codigo fuente solo en los archivos del front-end.
* `grunt devel` - realiza el copiado de fuentes y concatena los archivos js y css del front-end, pero no los minifica (facilitando debbuguear).
* `grunt prod` - realiza el copiado de fuentes, concatena los archivos js y css del front-end y realiza el minificado de los js y css.
